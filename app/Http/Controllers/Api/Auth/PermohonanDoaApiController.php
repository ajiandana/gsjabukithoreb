<?php

namespace App\Http\Controllers\Api;

use App\Models\KategoriDoa;
use Illuminate\Http\Request;
use App\Models\PermohonanDoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermohonanDoaApiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('api.auth')->except(['getKategoriDoa']);
    }

    public function index()
    {
        $user = request()->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $permohonan = $user->permohonanDoa()
            ->with('kategori')->latest()->get();
        
        return response()->json([
            'status' => true,
            'data' => $permohonan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_doas,id',
            'isi_permohonan' => 'required|string',
            'perlu_konseling' => 'required|boolean',
            'no_hp' => 'required_if:perlu_konseling,true|nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::guard('api')->user();

        $permohonan = PermohonanDoa::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'kategori_id' => $request->kategori_id,
            'isi_permohonan' => $request->isi_permohonan,
            'perlu_konseling' => $request->perlu_konseling,
            'no_hp' => $request->perlu_konseling ? $request->no_hp : null,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Permohonan doa berhasil dikirim',
            'data' => $permohonan->load('kategori')
        ], 201);
    }

    public function show($id)
    {
        $user = request()->user();
        $permohonan = $user->permohonanDoa()->with('kategori')->find($id);
        
        if (!$permohonan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan doa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $permohonan
        ]);
    }

    public function getKategoriDoa()
    {
        $kategori = KategoriDoa::all();
        
        return response()->json([
            'status' => true,
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'kategori_id' => 'required|exists:kategori_doas,id',
            'isi_permohonan' => 'required|string',
            'perlu_konseling' => 'required|boolean',
            'no_hp' => 'required_if:perlu_konseling,true|nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $permohonan = PermohonanDoa::where('user_id', Auth::id())->find($id);
        if (!$permohonan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan anda tidak ditemukan'
            ], 404);
        }

        $permohonan->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Permohonan anda berhasil diperbarui',
            'data' => $permohonan
        ]);
    }

    public function destroy($id)
    {
        $permohonan = PermohonanDoa::where('user_id', Auth::id())->find($id);
        if (!$permohonan) {
            return response()->json([
                'status' => false,
                'message' => 'Permohonan anda tidak ditemukan'
            ], 404);
        }

        $permohonan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permohonan anda berhasil dihapus'
        ]);
    }
}
