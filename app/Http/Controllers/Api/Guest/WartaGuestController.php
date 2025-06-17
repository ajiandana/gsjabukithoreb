<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Warta;
use Illuminate\Http\JsonResponse;

class WartaGuestController extends Controller
{
    public function index(): JsonResponse
    {
        $warta = Warta::latest()->get([
            'id', 'judul', 'gambar', 'penulis', 'bulan', 'tahun'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'List warta berhasil diambil',
            'data' => $warta
        ]);
    }

    public function show($id): JsonResponse
    {
        $warta = Warta::select('id', 'judul', 'gambar', 'penulis', 'bulan', 'tahun', 'isi')
            ->find($id);

        if (!$warta) {
            return response()->json([
                'status' => false,
                'message' => 'Warta tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => false,
            'message' => 'Detail warta berhasil diambil',
            'data' => $warta
        ]);
    }
}