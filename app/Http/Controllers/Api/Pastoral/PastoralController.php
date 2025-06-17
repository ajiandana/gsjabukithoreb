<?php

namespace App\Http\Controllers\Api\Pastoral;

use App\Models\User;
use App\Models\Pastoral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PastoralController extends Controller
{
    public function index()
    {
        // $pastoral = User::where('role', 'pastoral')->get();
        $pastoral = Pastoral::with('statusPastoral')->get();
        
        return response()->json([
            'status' => true,
            'data' => $pastoral
        ]);
    }

    public function show($id)
    {
        $pastoral = Pastoral::with('statusPastoral')->findOrFail($id);
        
        if ($pastoral->user_id === Auth::id()) {
            return response()->json([
                'status' => true,
                'data' => $pastoral]);
        }
        
        return response()->json([
            'status' => true,
            'data' => $pastoral->only(['id', 'nama', 'status_pastoral_id'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        // $pastoral = Pastoral::where('user_id', Auth::id())->findOrFail($id);
        
        if ($user->id != $id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda hanya dapat memperbarui data diri sendiri'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:6',
            'no_hp' => 'sometimes|string|max:20',
            'alamat' => 'sometimes|string',
            'bio' => 'sometimes|string',
            'link_lokasi' => 'sometimes|nullable|url',
            'foto' => 'sometimes|nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['name', 'email']);
        
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $user
        ]);
    }
}