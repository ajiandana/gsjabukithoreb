<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Pastoral;
use Illuminate\Http\JsonResponse;

class PastoralGuestController extends Controller
{
    public function index(): JsonResponse
    {
        $pastorals = Pastoral::select(
            'nama',
            'tempat_lahir',
            'tgl_lahir',
            'bio',
            'foto'
        )->get();

        return response()->json([
            'status' => true,
            'message' => 'Data pastoral berhasil diambil',
            'data' => $pastorals
        ]);
    }
}