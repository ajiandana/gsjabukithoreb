<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenyerahanAnak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenyerahanAnakApiController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $permohonan = $user->penyerahanAnak()->latest()->get();
        
        return response()->json([
            'status' => true,
            'data' => $permohonan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_anak' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'no_hp' => 'required|string|regex:/^[0-9]{10,15}$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $penyerahan = PenyerahanAnak::create([
            'user_id' => Auth::id(),
            'nama_anak' => $request->nama_anak,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'no_hp' => $request->no_hp,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Permohonan penyerahan anak berhasil dikirim',
            'data' => $penyerahan
        ], 201);
    }

    public function show($id)
    {
        $user = request()->user();
        $penyerahan = $user->penyerahanAnak()->find($id);
        
        if (!$penyerahan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan penyerahan anak tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $penyerahan
        ]);
    }
}