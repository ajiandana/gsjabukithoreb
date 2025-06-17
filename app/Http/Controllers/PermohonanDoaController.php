<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanDoa;

class PermohonanDoaController extends Controller
{
    public function index()
    {
        $permohonans = PermohonanDoa::with('kategori')->latest()->get();
        return view('permohonan-doa.index', compact('permohonans'));
    }

    public function updateStatus(Request $request, PermohonanDoa $permohonan)
    {
        $permohonan->update(['status' => $request->status]);
        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required|exists:kategori_doas,id',
            'isi_permohonan' => 'required',
            'perlu_konseling' => 'boolean'
        ]);

        $permohonan = PermohonanDoa::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'isi_permohonan' => $request->isi_permohonan,
            'perlu_konseling' => $request->perlu_konseling ?? false,
            'no_hp' => $request->perlu_konseling ? $request->no_hp : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan doa berhasil dikirim'
        ]);
    }
    public function destroy(PermohonanDoa $permohonan_doa)
    {
        $permohonan_doa->delete();
        return redirect()->route('permohonan-doa.index')->with('success', 'Permohonan berhasil dihapus');
    }
}
