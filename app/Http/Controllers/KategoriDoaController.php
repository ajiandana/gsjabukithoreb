<?php

namespace App\Http\Controllers;

use App\Models\KategoriDoa;
use Illuminate\Http\Request;

class KategoriDoaController extends Controller
{
    public function index()
    {
        $kategoris = KategoriDoa::all();
        return view('kategori-doa.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        KategoriDoa::create($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, KategoriDoa $kategoriDoa)
    {
        $kategoriDoa->update($request->all());
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(KategoriDoa $kategoriDoa)
    {
        $kategoriDoa->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
