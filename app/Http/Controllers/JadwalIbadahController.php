<?php

namespace App\Http\Controllers;

use App\Models\JadwalIbadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalIbadahController extends Controller
{
    public function index()
    {
        $jadwals = JadwalIbadah::latest()->get();
        return view('jadwal-ibadah.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal-ibadah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'keterangan' => 'nullable'
        ]);

        $path = $request->file('gambar')->store('jadwal-ibadah', 'public');

        JadwalIbadah::create([
            'judul' => $request->judul,
            'gambar' => $path,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('jadwal-ibadah.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function download($id)
    {
        $jadwal = JadwalIbadah::findOrFail($id);
        if (!Storage::disk('public')->exists($jadwal->gambar)) {
            abort(404, 'File tidak ditemukan');
        }
        $extension = pathinfo($jadwal->gambar, PATHINFO_EXTENSION);
        $filename = "jadwal-ibadah-{$jadwal->bulan}-{$jadwal->tahun}.{$extension}";
        $path = Storage::disk('public')->path($jadwal->gambar);
        return response()->download($path, $filename, [
            'Content-Type' => mime_content_type($path),
            'Cache-Control' => 'no-store, no-cache'
        ]);
    }

    public function destroy($id)
    {
        $jadwal = JadwalIbadah::findOrFail($id);
        Storage::disk('public')->delete($jadwal->gambar);
        $jadwal->delete();
        
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}