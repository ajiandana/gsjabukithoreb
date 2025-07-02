<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baptis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BaptisApiController extends Controller
{
    public function index()
    {
        $user = request()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $permohonan = $user->baptis()->latest()->get();
        
        return response()->json([
            'status' => true,
            'data' => $permohonan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'no_hp' => 'required|string|regex:/^[0-9]{10,15}$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $baptis = Baptis::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'no_hp' => $request->no_hp,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Permohonan baptis berhasil dikirim',
            'data' => $baptis
        ], 201);
    }

    public function show($id)
    {
        $user = request()->user();
        $baptis = $user->baptis()->find($id);
        
        if (!$baptis) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan baptis tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $baptis
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'no_hp' => 'required|string|regex:/^[0-9]{10,15}$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $baptis = Baptis::where('user_id', Auth::id())->find($id);
        if (!$baptis) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan baptis tidak ditemukan'
            ], 404);
        }

        $baptis->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Permohonan baptis berhasil diperbarui',
            'data' => $baptis
        ]);
    }

    public function destroy($id)
    {
        $baptis = Baptis::where('user_id', Auth::id())->find($id);
        if (!$baptis) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan baptis tidak ditemukan'
            ], 404);
        }

        $baptis->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permohonan baptis berhasil dihapus'
        ]);
    }
}