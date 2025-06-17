<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\JsonResponse;

class GaleriGuestController extends Controller
{
    public function index(): JsonResponse
    {
        $kegiatan = Kegiatan::with(['galeri:id,kegiatan_id,gambar,caption'])
            ->orderBy('tanggal', 'desc')
            ->get(['id', 'judul', 'deskripsi', 'tanggal']);

        $formatted = $kegiatan->map(function ($item) {
            return [
                'judul' => $item->judul,
                'tanggal' => $item->tanggal,
                'deskripsi' => $item->deskripsi,
                'galeri' => $item->galeri->map(function ($g) {
                    return [
                        'gambar' => $g->gambar,
                        'caption' => $g->caption
                    ];
                })
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Galeri kegiatan berhasil diambil',
            'data' => $formatted
        ]);
    }
}