<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventGuestController extends Controller
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