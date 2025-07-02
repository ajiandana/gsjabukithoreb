<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemberkatanNikah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemberkatanNikahApiController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $permohonan = $user->pemberkatanNikah()->latest()->get();
        
        return response()->json([
            'status' => true,
            'data' => $permohonan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Validasi Data Pria
            'pria_nama' => 'required|string|max:100',
            'pria_sudah_baptis' => 'required|boolean',
            'pria_ayah' => 'required|string|max:100',
            'pria_ibu' => 'required|string|max:100',
            // Validasi Data Wanita
            'wanita_nama' => 'required|string|max:100',
            'wanita_sudah_baptis' => 'required|boolean',
            'wanita_ayah' => 'required|string|max:100',
            'wanita_ibu' => 'required|string|max:100',
            // Validasi Data Pernikahan
            'rencana_tahun' => 'required|digits:4|integer|min:'.date('Y').'|max:'.(date('Y')+2),
            'no_hp' => 'required|string|regex:/^[0-9]{10,15}$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pemberkatan = PemberkatanNikah::create([
            'user_id' => Auth::id(),
            // Data Pria
            'pria_nama' => $request->pria_nama,
            'pria_sudah_baptis' => $request->pria_sudah_baptis,
            'pria_ayah' => $request->pria_ayah,
            'pria_ibu' => $request->pria_ibu,
            // Data Wanita
            'wanita_nama' => $request->wanita_nama,
            'wanita_sudah_baptis' => $request->wanita_sudah_baptis,
            'wanita_ayah' => $request->wanita_ayah,
            'wanita_ibu' => $request->wanita_ibu,
            // Data Pernikahan
            'rencana_tahun' => $request->rencana_tahun,
            'no_hp' => $request->no_hp,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Permohonan pemberkatan nikah berhasil dikirim',
            'data' => $pemberkatan
        ], 201);
    }

    public function show($id)
    {
        $user = request()->user();
        $pemberkatan = $user->pemberkatanNikah()->find($id);
        
        if (!$pemberkatan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan pemberkatan nikah tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $pemberkatan
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // Validasi Data Pria
            'pria_nama' => 'required|string|max:100',
            'pria_sudah_baptis' => 'required|boolean',
            'pria_ayah' => 'required|string|max:100',
            'pria_ibu' => 'required|string|max:100',
            // Validasi Data Wanita
            'wanita_nama' => 'required|string|max:100',
            'wanita_sudah_baptis' => 'required|boolean',
            'wanita_ayah' => 'required|string|max:100',
            'wanita_ibu' => 'required|string|max:100',
            // Validasi Data Pernikahan
            'rencana_tahun' => 'required|digits:4|integer|min:'.date('Y').'|max:'.(date('Y')+2),
            'no_hp' => 'required|string|regex:/^[0-9]{10,15}$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pemberkatan = PemberkatanNikah::where('user_id', Auth::id())->find($id);
        if (!$pemberkatan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan anda tidak ditemukan'
            ], 404);
        }

        $pemberkatan->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Permohonan anda berhasil diperbarui',
            'data' => $pemberkatan
        ]);
    }

    public function destroy($id)
    {
        $pemberkatan = PemberkatanNikah::where('user_id', Auth::id())->find($id);
        if (!$pemberkatan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan anda tidak ditemukan'
            ], 404);
        }

        $pemberkatan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permohonan anda berhasil dihapus'
        ]);
    }
}