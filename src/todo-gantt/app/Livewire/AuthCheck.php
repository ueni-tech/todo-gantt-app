<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuthCheck extends Component
{
    public function checkAuth()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    public function render()
    {
        return view('livewire.auth-check');
    }
}
