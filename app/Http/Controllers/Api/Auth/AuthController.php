<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $request->role;
        $token = Str::random(60);
        $user->api_token = $token;
        $user->save();

        // $user = User::create([
        //     'name' => $validated['name'],
        //     'email' => $validated['email'],
        //     'password' => bcrypt($validated['password']),
        //     'role' => 'jemaat',
        // ]);

        // $token = Str::random(60);
        // $user->api_token = $token;
        // $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendaftar',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();

        $plainToken = $user->generateToken();

        return response()->json([
            'status' => true,
            'token' => $plainToken,
            'user' => $user->only(['id', 'name', 'email', 'role'])
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        $response = [
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'token_valid' => true
        ];

        if ($user->role === 'pastoral') {
            $pastoral = $user->pastoral()->first();
            $response['pastoral_data'] = $pastoral ? [
                'id' => $pastoral->id,
                'nama' => $pastoral->nama,
                'status_pastoral' => $pastoral->status->nama ?? 'Tidak diketahui'
            ] : null;
        } else {
            $response['pastoral_data'] = null;
            $response['warning'] = 'Data pastoral tidak ditemukan';
        }

        //Tambahkan data tambahan untuk role jemaat
        if ($user->role === 'jemaat') {
            $jemaat = $user->jemaat()->first();
            $response['jemaat_data'] = $jemaat ? [
                'id' => $jemaat->id,
            ] : null;
        }

        return response()->json([
            'status' => true,
            'data' => $response
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response()->json(['status' => true, 'message' => 'Successfully logged out']);
    }
}