<?php

namespace App\Http\Controllers\Api\Auth;

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

            // $kegiatan = Kegiatan::with(['galeri:id,kegiatan_id,gambar,caption'])
            //     ->orderBy('tanggal', 'desc')
            //     ->get(['id', 'judul', 'deskripsi', 'tanggal']);

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
}