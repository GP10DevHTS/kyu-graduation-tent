<?php

namespace App\Livewire\Graduands;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListAllGraduands extends Component
{
    use WithPagination;

    public $search = '';


    public function render()
    {
        return view('livewire.graduands.list-all-graduands', [
            'graduands' => User::when($this->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->paginate(50),
        ]);
    }

    public function createChat($id){
        $conversation = auth()->user()->createConversationWith(User::find($id));

        $this->redirectRoute('chat', ['conversation_id' => $conversation->id]);
    }
}
