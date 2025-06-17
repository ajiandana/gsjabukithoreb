<?php

namespace App\Http\Controllers\Api\Pastoral;

use App\Http\Controllers\Controller;
use App\Models\PermohonanDoa;
use App\Models\Baptis;
use App\Models\PenyerahanAnak;
use App\Models\PemberkatanNikah;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonanDoa = PermohonanDoa::with(['user', 'kategori'])->latest()->get();
        $baptis = Baptis::with('user')->latest()->get();
        $penyerahanAnak = PenyerahanAnak::with('user')->latest()->get();
        $pemberkatanNikah = PemberkatanNikah::with('user')->latest()->get();

        return response()->json([
            'status' => true,
            'permohonan_doa' => $permohonanDoa,
            'baptis' => $baptis,
            'penyerahan_anak' => $penyerahanAnak,
            'pemberkatan_nikah' => $pemberkatanNikah
        ]);
    }

    public function updateStatus(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        switch ($type) {
            case 'doa':
                $permohonan = PermohonanDoa::findOrFail($id);
                break;
            case 'baptis':
                $permohonan = Baptis::findOrFail($id);
                break;
            case 'penyerahan-anak':
                $permohonan = PenyerahanAnak::findOrFail($id);
                break;
            case 'pemberkatan-nikah':
                $permohonan = PemberkatanNikah::findOrFail($id);
                break;
            default:
                return response()->json(['message' => 'Jenis permohonan tidak valid'], 400);
        }

        $permohonan->update(['status' => $validated['status']]);

        return response()->json([
            'status' => true,
            'message' => 'Status permohonan berhasil diperbarui']);
    }
}
