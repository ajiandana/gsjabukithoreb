<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::where('status', '!=', 'selesai')
            ->orderBy('tanggal', 'asc')
            ->get(['judul', 'tanggal', 'tanggal_selesai', 'jam_mulai', 'jam_selesai', 'tempat', 'informasi']);

        return response()->json([
            'status' => true,
            'message' => 'Daftar event aktif berhasil diambil',
            'data' => $events
        ]);
    }
}
