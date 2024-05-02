<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')->user();
            $email = $socialiteUser->email;

            $user = User::updateOrCreate([
                'provider_id' => $socialiteUser->id,
                'provider' => 'google',
            ], [
                'name' => $socialiteUser->name,
                'email' => $email
            ]);

            Auth::login($user);

            return redirect(route('index'));
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
