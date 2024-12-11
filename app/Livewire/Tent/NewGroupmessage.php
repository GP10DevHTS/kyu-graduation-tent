<?php

namespace App\Livewire\Tent;

use App\Models\Group;
use App\Models\GroupChatMessage;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewGroupmessage extends Component
{
    use WithFileUploads;

    public $group_id;
    public $message = '';
    public $attachments = [];

    // Remove the Pusher property
    // public $pusher; // Remove this line

    protected $rules = [
        'message' => 'nullable|string|max:5000',
        'attachments.*' => 'nullable|file|max:10240',
    ];

    public function mount($groupId = null)
    {
        // If group ID is not provided, find the first group the user belongs to
        if (!$groupId) {
            $groupUser = GroupUser::where('user_id', Auth::id())->first();
            $this->group_id = $groupUser ? $groupUser->group_id : null;
        } else {
            $this->group_id = $groupId;
        }
    }

    public function sendMessage()
    {
        $this->validate();

        // Find the group and sender
        $groupUser = GroupUser::where('user_id', Auth::id())
            ->where('group_id', $this->group_id)
            ->first();

        if (!$groupUser) {
            session()->flash('error', 'You are not a member of this group.');
            return;
        }

        // Store attachments
        $attachmentPaths = [];
        foreach ($this->attachments as $attachment) {
            $path = $attachment->store('group_chat_attachments', 'public');
            $attachmentPaths[] = $path;
        }

        // Create message
        $message = GroupChatMessage::create([
            'group_id' => $this->group_id,
            'sender_id' => $groupUser->id,
            'message' => $this->message,
            'attaments' => json_encode($attachmentPaths) // Encode attachments
        ]);

        // Send Pusher event directly without storing Pusher as a property
        try {
            $pusher = new Pusher(
                config('chatify.pusher.key'),
                config('chatify.pusher.secret'),
                config('chatify.pusher.app_id'),
                config('chatify.pusher.options')
            );

            $pusher->trigger(
                'private-group-' . $this->group_id,
                'new-group-message',
                [
                    'id' => $message->id,
                    'group_id' => $this->group_id,
                    'sender_id' => $groupUser->id,
                    'message' => $this->message,
                    'attachments' => $attachmentPaths,
                    'sender_name' => Auth::user()->name,
                    'sent_at' => $message->created_at->toDateTimeString(),
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Pusher event error: ' . $e->getMessage());
        }

        // Reset form
        $this->reset(['message', 'attachments']);

        // Dispatch local event
        $this->dispatch('message-sent', messageId: $message->id);

        // Flash success message
        session()->flash('success', 'Message sent successfully!');
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function render()
    {
        return view('livewire.tent.new-groupmessage');
    }
}