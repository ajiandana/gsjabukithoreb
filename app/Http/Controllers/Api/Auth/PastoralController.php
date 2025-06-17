<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Pastoral;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PastoralController extends Controller
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
