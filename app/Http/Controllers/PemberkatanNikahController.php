<?php

namespace App\Http\Controllers;

use App\Models\PemberkatanNikah;
use Illuminate\Http\Request;

class PemberkatanNikahController extends Controller
{
    public function index()
    {
        $pemberkatan = PemberkatanNikah::latest()->get();
        return view('pemberkatan-nikah.index', compact('pemberkatan'));
    }

    public function create()
    {
        return view('pemberkatan-nikah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validasi Pria
            'pria_nama' => 'required|string|max:100',
            'pria_sudah_baptis' => 'required|boolean',
            'pria_ayah' => 'required|string|max:100',
            'pria_ibu' => 'required|string|max:100',
            
            // Validasi Wanita
            'wanita_nama' => 'required|string|max:100',
            'wanita_sudah_baptis' => 'required|boolean',
            'wanita_ayah' => 'required|string|max:100',
            'wanita_ibu' => 'required|string|max:100',
            
            // Validasi Pernikahan
            'rencana_tahun' => 'required|digits:4|integer|min:'.date('Y'),
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        PemberkatanNikah::create($validated);

        return redirect()->route('pemberkatan-nikah.index')
            ->with('success', 'Data pemberkatan nikah berhasil ditambahkan');
    }

    public function show(PemberkatanNikah $pemberkatanNikah)
    {
        return view('pemberkatan-nikah.show', compact('pemberkatanNikah'));
    }

    public function edit(PemberkatanNikah $pemberkatanNikah)
    {
        return view('pemberkatan-nikah.edit', compact('pemberkatanNikah'));
    }

    public function update(Request $request, PemberkatanNikah $pemberkatanNikah)
    {
        $validated = $request->validate([
            // Validasi Pria
            'pria_nama' => 'required|string|max:100',
            'pria_sudah_baptis' => 'required|boolean',
            'pria_ayah' => 'required|string|max:100',
            'pria_ibu' => 'required|string|max:100',
            
            // Validasi Wanita
            'wanita_nama' => 'required|string|max:100',
            'wanita_sudah_baptis' => 'required|boolean',
            'wanita_ayah' => 'required|string|max:100',
            'wanita_ibu' => 'required|string|max:100',
            
            // Validasi Pernikahan
            'rencana_tahun' => 'required|digits:4|integer|min:'.date('Y'),
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        $pemberkatanNikah->update($validated);

        return redirect()->route('pemberkatan-nikah.index')
            ->with('success', 'Data pemberkatan nikah berhasil diperbarui');
    }

    public function destroy(PemberkatanNikah $pemberkatanNikah)
    {
        $pemberkatanNikah->delete();

        return redirect()->route('pemberkatan-nikah.index')
            ->with('success', 'Data pemberkatan nikah berhasil dihapus');
    }
}