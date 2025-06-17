<?php

namespace App\Http\Controllers;

use App\Models\PenyerahanAnak;
use Illuminate\Http\Request;

class PenyerahanAnakController extends Controller
{
    public function index()
    {
        $penyerahanAnak = PenyerahanAnak::latest()->get();
        return view('penyerahan-anak.index', compact('penyerahanAnak'));
    }

    public function create()
    {
        return view('penyerahan-anak.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        PenyerahanAnak::create($validated);

        return redirect()->route('penyerahan-anak.index')
            ->with('success', 'Data penyerahan anak berhasil ditambahkan');
    }

    public function show(PenyerahanAnak $penyerahanAnak)
    {
        return view('penyerahan-anak.show', compact('penyerahanAnak'));
    }

    public function edit(PenyerahanAnak $penyerahanAnak)
    {
        return view('penyerahan-anak.edit', compact('penyerahanAnak'));
    }

    public function update(Request $request, PenyerahanAnak $penyerahanAnak)
    {
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        $penyerahanAnak->update($validated);

        return redirect()->route('penyerahan-anak.index')
            ->with('success', 'Data penyerahan anak berhasil diperbarui');
    }

    public function destroy(PenyerahanAnak $penyerahanAnak)
    {
        $penyerahanAnak->delete();

        return redirect()->route('penyerahan-anak.index')
            ->with('success', 'Data penyerahan anak berhasil dihapus');
    }
}