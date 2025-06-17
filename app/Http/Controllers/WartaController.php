<?php

namespace App\Http\Controllers;

use App\Models\Warta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WartaController extends Controller
{
    public function index()
    {
        $wartas = Warta::latest()->get();
        return view('warta.index', compact('wartas'));
    }

    public function create()
    {
        return view('warta.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5012',
            'penulis' => 'required',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'isi' => 'required'
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('warta', 'public');
            $validated['gambar'] = $path;
        }

        Warta::create($validated);

        return redirect()->route('warta.index')
               ->with('success', 'Warta berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $warta = Warta::findOrFail($id);
        return view('warta.edit', compact('warta'));
    }

    public function update(Request $request, $id)
    {
        $warta = Warta::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5012',
            'penulis' => 'required',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'isi' => 'required',
            'hapus_gambar' => 'nullable'
        ]);

        if ($request->hapus_gambar) {
            Storage::disk('public')->delete($warta->gambar);
            $validated['gambar'] = null;
        }
    
        if ($request->hasFile('gambar')) {
            if ($warta->gambar) {
                Storage::disk('public')->delete($warta->gambar);
            }
            $path = $request->file('gambar')->store('warta', 'public');
            $validated['gambar'] = $path;
        }

        $warta->update($validated);

        return redirect()->route('warta.index')
            ->with('success', 'Warta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $warta = Warta::findOrFail($id);
        
        // Hapus gambar terkait
        if ($warta->gambar) {
            Storage::delete('public/' . $warta->gambar);
        }
        
        $warta->delete();
        
        return redirect()->route('warta.index')
               ->with('success', 'Warta berhasil dihapus!');
    }
}