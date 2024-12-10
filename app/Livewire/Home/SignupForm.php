<?php

namespace App\Livewire\Home;

use Livewire\Component;

class SignupForm extends Component
{
    public $email;
    public function render()
    {
        return view('livewire.home.signup-form');
    }

    public function subscribe(){
        $this->validate([
            'email' => 'required|email|unique:users'
        ]);

        if($this->email){
            // redirect to registration page with email
            
            return redirect()->route('register', ['email' => $this->email]);
        }
    }
}
