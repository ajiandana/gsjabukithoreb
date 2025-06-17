<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Hanya admin yang boleh mengakses.']);
            }

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
