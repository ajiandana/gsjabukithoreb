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
        try {
            $ongoingEvents = Event::berlangsung()->get();
            $upcomingEvents = Event::segera()->get();
            
            $events = $ongoingEvents->concat($upcomingEvents)->map(function ($event) {
                return [
                    'id' => $event->id,
                    'gambar' => $event->gambar,
                    'judul' => $event->judul,
                    'tanggal' => $event->tanggal->format('Y-m-d'),
                    'tanggal_selesai' => $event->tanggal_selesai ? $event->tanggal_selesai->format('Y-m-d') : null,
                    'jam_mulai' => $event->jam_mulai ? $event->jam_mulai->format('H:i') : null,
                    'jam_selesai' => $event->jam_selesai ? $event->jam_selesai->format('H:i') : null,
                    'tempat' => $event->tempat,
                    'informasi' => $event->informasi,
                    'status' => $event->status,
                    'is_multi_day' => $event->is_multi_day,
                    'tanggal_formatted' => $this->formatTanggal($event->tanggal, $event->tanggal_selesai, $event->is_multi_day),
                    'waktu_formatted' => $this->formatWaktu($event->jam_mulai, $event->jam_selesai)
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Daftar event aktif berhasil diambil',
                'data' => $events
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            
            $eventData = [
                'id' => $event->id,
                'gambar' => $event->gambar,
                'judul' => $event->judul,
                'tanggal' => $event->tanggal->format('Y-m-d'),
                'tanggal_selesai' => $event->tanggal_selesai ? $event->tanggal_selesai->format('Y-m-d') : null,
                'jam_mulai' => $event->jam_mulai ? $event->jam_mulai->format('H:i') : null,
                'jam_selesai' => $event->jam_selesai ? $event->jam_selesai->format('H:i') : null,
                'tempat' => $event->tempat,
                'informasi' => $event->informasi,
                'status' => $event->status,
                'is_multi_day' => $event->is_multi_day,
                'tanggal_formatted' => $this->formatTanggal($event->tanggal, $event->tanggal_selesai, $event->is_multi_day),
                'waktu_formatted' => $this->formatWaktu($event->jam_mulai, $event->jam_selesai)
            ];

            return response()->json([
                'status' => true,
                'message' => 'Detail event berhasil diambil',
                'data' => $eventData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Event tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function past(): JsonResponse
    {
        try {
            $events = Event::selesai()->get()->map(function ($event) {
                return [
                    'id' => $event->id,
                    'gambar' => $event->gambar,
                    'judul' => $event->judul,
                    'tanggal' => $event->tanggal->format('Y-m-d'),
                    'tanggal_selesai' => $event->tanggal_selesai ? $event->tanggal_selesai->format('Y-m-d') : null,
                    'tempat' => $event->tempat,
                    'status' => $event->status,
                    'is_multi_day' => $event->is_multi_day,
                    'tanggal_formatted' => $this->formatTanggal($event->tanggal, $event->tanggal_selesai, $event->is_multi_day)
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Daftar event yang sudah lewat berhasil diambil',
                'data' => $events
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function formatTanggal($tanggal, $tanggalSelesai = null, $isMultiDay = false)
    {
        $bulanIndonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $startDate = \Carbon\Carbon::parse($tanggal);
        $formatted = $startDate->day . ' ' . $bulanIndonesia[$startDate->month] . ' ' . $startDate->year;

        if ($isMultiDay && $tanggalSelesai) {
            $endDate = \Carbon\Carbon::parse($tanggalSelesai);
            $formatted .= ' - ' . $endDate->day . ' ' . $bulanIndonesia[$endDate->month] . ' ' . $endDate->year;
        }

        return $formatted;
    }

    private function formatWaktu($jamMulai, $jamSelesai = null)
    {
        if (!$jamMulai) return null;

        $waktu = \Carbon\Carbon::parse($jamMulai)->format('H:i');
        if ($jamSelesai) {
            $waktu .= ' - ' . \Carbon\Carbon::parse($jamSelesai)->format('H:i');
        }
        return $waktu . ' WIB';
    }
}