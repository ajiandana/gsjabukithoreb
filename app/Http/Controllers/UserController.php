<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request, )
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,pastoral,jemaat'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'api_token' => Str::random(60),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,pastoral,jemaat',
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];
    
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
    
        $user->update($data);
    
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
