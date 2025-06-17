<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            }
            Auth::logout();
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
