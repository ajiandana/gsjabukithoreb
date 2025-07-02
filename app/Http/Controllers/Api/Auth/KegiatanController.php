<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Galeri;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $kegiatan = Kegiatan::with(['galeri:id,kegiatan_id,gambar,caption'])->findOrFail($id);

            $formatted = [
                'id' => $kegiatan->id,
                'judul' => $kegiatan->judul,
                'tanggal' => $kegiatan->tanggal,
                'deskripsi' => $kegiatan->deskripsi,
                'galeri' => $kegiatan->galeri->map(function ($g) {
                    return [
                        'id' => $g->id,
                        'kegiatan_id' => $g->kegiatan_id,
                        'gambar' => $g->gambar,
                        'caption' => $g->caption
                    ];
                })
            ];

            return response()->json([
                'status' => true,
                'message' => 'Galeri kegiatan berhasil diambil',
                'data' => [$formatted]
            ]);
        } else {
            $kegiatan = Kegiatan::with(['galeri:id,kegiatan_id,gambar,caption'])
                ->orderBy('tanggal', 'desc')
                ->get(['id', 'judul', 'deskripsi', 'tanggal']);

            $formatted = $kegiatan->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'tanggal' => $item->tanggal,
                    'deskripsi' => $item->deskripsi,
                    'galeri' => $item->galeri->map(function ($g) {
                        return [
                            'id' => $g->id,
                            'kegiatan_id' => $g->kegiatan_id,
                            'gambar' => $g->gambar,
                            'caption' => $g->caption
                        ];
                    })
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Daftar kegiatan berhasil diambil',
                'data' => $formatted
            ]);
        }
    }

    public function recent()
    {
        $recentGaleri = Galeri::orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'gambar', 'caption', 'created_at']);

        return response()->json([
            'status' => true,
            'message' => 'Galeri terbaru berhasil diambil',
            'data' => $recentGaleri
        ]);
    }
}