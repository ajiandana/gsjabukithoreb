<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use Illuminate\Http\Request;

class BaptisController extends Controller
{
    public function index()
    {
        $baptis = Baptis::latest()->get();
        return view('baptis.index', compact('baptis'));
    }

    public function create()
    {
        return view('baptis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        Baptis::create($validated);

        return redirect()->route('baptis.index')
            ->with('success', 'Data baptis berhasil ditambahkan');
    }

    public function show(Baptis $bapti)
    {
        return view('baptis.show', compact('bapti'));
    }

    public function edit(Baptis $bapti)
    {
        return view('baptis.edit', compact('bapti'));
    }

    public function update(Request $request, Baptis $bapti)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        $bapti->update($validated);

        return redirect()->route('baptis.index')
            ->with('success', 'Data baptis berhasil diperbarui');
    }

    public function destroy(Baptis $bapti)
    {
        $bapti->delete();
        return redirect()->route('baptis.index')->with('success', 'Data baptis berhasil dihapus');
    }
}
