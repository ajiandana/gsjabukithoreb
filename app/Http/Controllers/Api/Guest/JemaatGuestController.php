<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use Illuminate\Http\JsonResponse;

class JemaatGuestController extends Controller
{
    public function count(): JsonResponse
    {
        $total = Jemaat::count();
        $laki = Jemaat::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Jemaat::where('jenis_kelamin', 'Perempuan')->count();

        return response()->json([
            'status' => true,
            'message' => 'Statistik jemaat berhasil diambil',
            'data' => [
                'total' => $total,
                'laki_laki' => $laki,
                'perempuan' => $perempuan
            ]
        ]);
    }
}