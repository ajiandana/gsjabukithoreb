<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\JadwalIbadah;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class JadwalIbadahController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $jadwal = JadwalIbadah::latest()->get([
                'id', 'judul', 'gambar', 'bulan', 'tahun', 'keterangan'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'List jadwal ibadah berhasil diambil',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data jadwal ibadah',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $jadwal = JadwalIbadah::select('id', 'judul', 'gambar', 'bulan', 'tahun', 'keterangan')
                ->find($id);

            if (!$jadwal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Jadwal ibadah tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Detail jadwal ibadah berhasil diambil',
                'data' => $jadwal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil detail jadwal ibadah',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
