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
        if (Auth::check()) {
            return redirect()->route('index');
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

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

            $request->session()->regenerate();
            $request->session()->put('login_completed', true);

            return redirect()->route('index')->with('login_success', true);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('login')->with('error', 'Google認証に失敗しました。');
        }
    }
}
