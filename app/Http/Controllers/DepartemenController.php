<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Pastoral;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::with(['pastoral', 'pengurus.jemaat'])->latest()->get();
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        $pastorals = Pastoral::all();
        $jemaats = Jemaat::all();
        return view('departemen.form', compact('pastorals', 'jemaats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'pastoral_id' => 'nullable|exists:pastorals,id',
            'informasi' => 'nullable|string',
            'ketua_id' => 'required|exists:jemaats,id',
            'wakil_id' => 'required|exists:jemaats,id',
            'sekretaris_id' => 'required|exists:jemaats,id',
            'bendahara_id' => 'required|exists:jemaats,id'
        ]);

        $departemen = Departemen::create($request->only(['nama', 'pastoral_id', 'informasi']));

        $this->simpanPengurus($departemen, $request);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function show(Departemen $departemen)
    {
        $departemen->load(['pengurus.jemaat', 'pastoral']);
        return view('departemen.show', compact('departemen'));
    }

    public function edit(Departemen $departemen)
    {
        $pastorals = Pastoral::all();
        $jemaats = Jemaat::all();
        return view('departemen.form', compact('departemen', 'pastorals', 'jemaats'));
    }

    public function update(Departemen $departemen, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'pastoral_id' => 'nullable|exists:pastorals,id',
            'informasi' => 'nullable|string',
            'ketua_id' => 'required|exists:jemaats,id',
            'wakil_id' => 'required|exists:jemaats,id',
            'sekretaris_id' => 'required|exists:jemaats,id',
            'bendahara_id' => 'required|exists:jemaats,id'
        ]);

        $departemen->update($request->only(['nama', 'pastoral_id', 'informasi']));

        // Update pengurus
        $departemen->pengurus()->delete();
        $this->simpanPengurus($departemen, $request);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui!');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus!');
    }

    private function simpanPengurus($departemen, $request)
    {
        $pengurus = [];
        
        if ($request->ketua_id) {
            $pengurus[] = ['jemaat_id' => $request->ketua_id, 'jabatan' => 'ketua'];
        }
        if ($request->wakil_id) {
            $pengurus[] = ['jemaat_id' => $request->wakil_id, 'jabatan' => 'wakil'];
        }
        if ($request->sekretaris_id) {
            $pengurus[] = ['jemaat_id' => $request->sekretaris_id, 'jabatan' => 'sekretaris'];
        }
        if ($request->bendahara_id) {
            $pengurus[] = ['jemaat_id' => $request->bendahara_id, 'jabatan' => 'bendahara'];
        }

        if (!empty($pengurus)) {
            $departemen->pengurus()->createMany($pengurus);
        }
    }
}
