<?php
namespace App\Livewire\Tents;

use App\Models\GroupChatMessage;
use App\Models\Group;
use App\Models\GroupUser;
use Livewire\Component;

class MyGradTent extends Component
{
    public $myTent;
    public $groupMessages = [];

    // JavaScript hook to initialize Pusher
    public function mount()
    {
        $this->myTent = Group::whereHas('groupusers', function ($query) {
            $query->where('user_id', auth()->id());
        })->first();

        // Dispatch an event to initialize Pusher channel on the frontend
        $this->dispatch('init-pusher-channel', groupId: $this->myTent->id);

        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->groupMessages = $this->myTent
            ? GroupChatMessage::where('group_id', $this->myTent->id)
                ->with('sender.user') // Eager load relationships
                ->latest()
                ->get()
            : [];
    }

    public function render()
    {
        return view('livewire.tents.my-grad-tent', [
            'groupMessages' => $this->groupMessages,
            'members' => GroupUser::where('group_id', $this->myTent->id)->get(),
        ]);
    }
}