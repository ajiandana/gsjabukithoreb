<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use Illuminate\Http\JsonResponse;

class DepartemenGuestController extends Controller
{
    public function index(): JsonResponse
    {
        $departemen = Departemen::with([
            'pastoral:id,nama',
            'pengurus.jemaat:id,nama'
        ])->get();

        $result = $departemen->map(function ($item) {
            return [
                'nama' => $item->nama,
                'informasi' => $item->informasi,
                'pastoral' => $item->pastoral ? $item->pastoral->nama : null,
                'pengurus' => $item->pengurus->map(function ($p) {
                    return [
                        'nama' => $p->jemaat->nama ?? null,
                        'jabatan' => $p->jabatan,
                    ];
                })
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar departemen berhasil diambil',
            'data' => $result
        ]);
    }
}