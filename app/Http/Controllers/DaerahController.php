<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    public function index()
    {
        $daerahs = Daerah::latest()->get();
        return view('daerah.index', compact('daerahs'));
    }

    public function create()
    {
        return view('daerah.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:daerah',
            'keterangan' => 'nullable|string'
        ]);

        Daerah::create($request->all());
        return redirect()->route('daerah.index')->with('success', 'Daerah berhasil ditambahkan!');
    }

    public function show(Daerah $daerah)
    {
        //
    }

    public function edit($id)
    {
        $daerah = Daerah::findOrFail($id);
        return view('daerah.form', compact('daerah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:daerah,nama,'.$id,
            'keterangan' => 'nullable|string'
        ]);

        $daerah = Daerah::findOrFail($id);
        $daerah->update($request->all());
        return redirect()->route('daerah.index')->with('success', 'Daerah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $daerah = Daerah::findOrFail($id);

        if (!$daerah) {
            return redirect()->back()->with('error', 'Daerah tidak ditemukan!');
        }

        $daerah->delete();
        return redirect()->route('daerah.index')->with('success', 'Daerah berhasil dihapus!');
    }
}
