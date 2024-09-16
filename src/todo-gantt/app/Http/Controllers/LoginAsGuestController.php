<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAsGuestController extends Controller
{
    public function loginAsGuest(Request $request)
    {
        $request->validate([
            'guest_username' => 'required|string',
            'guest_password' => 'required|string',
        ]);

        $guestCredentials = [
            'name' => $request->guest_username,
            'password' => $request->guest_password,
        ];

        // ゲストユーザーを検索
        $guestUser = User::where('name', $guestCredentials['name'])
            ->where('provider', 'guest')
            ->first();

        // ゲストユーザーが存在しない、またはパスワードが一致しない場合
        if (!$guestUser || !Hash::check($guestCredentials['password'], $guestUser->password)) {
            return back()->withErrors([
                'guest_username' => 'ユーザー名またはパスワードが正しくありません。',
            ]);
        }

        // ゲストユーザーとしてログイン
        Auth::login($guestUser);

        $request->session()->regenerate();
        $request->session()->put('login_completed', true);

        // Sanctumトークンを生成
        $token = $guestUser->createToken('auth-token')->plainTextToken;
        $request->session()->put('sanctum_token', $token);

        return redirect()->route('index')->with('login_success', true);
    }
}
