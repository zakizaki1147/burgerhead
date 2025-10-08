<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity_type' => 'login',
                'description' => 'Logged in.'
            ]);

            return redirect()->intended('/dashboard')->with('success', 'Log in success! Welcome to Burgerhead!');
        }

        return back()->withErrors([
            'username' => 'Incorrect username or password!',
        ]);
    }

    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'logout',
            'description' => 'Logged out.'
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Log out success! See you later.');
    }
}
