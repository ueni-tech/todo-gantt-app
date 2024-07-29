<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth::guard('web')->logout();

        if (session()->isStarted()) {
            session()->flush();
            session()->regenerate(true);
        }

        session()->put('just_logged_out', true);
    }
}
