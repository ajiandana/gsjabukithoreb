<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\JadwalIbadah;
use Illuminate\Http\JsonResponse;

class JadwalIbadahGuestController extends Controller
{
    public function index(): JsonResponse
    {
        $jadwal = JadwalIbadah::latest()->get([
            'id', 'judul', 'gambar', 'bulan', 'tahun'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'List jadwal ibadah berhasil diambil',
            'data' => $jadwal
        ]);
    }

    public function show($id): JsonResponse
    {
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
    }
}