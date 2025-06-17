<?php

namespace App\Http\Controllers\Api\Pastoral;

use App\Models\Jemaat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JemaatController extends Controller
{
    public function index()
    {
        $jemaat = Jemaat::with('daerah')->latest()->get();
        return response()->json([
            'status' => true,
            'data' => $jemaat]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_jemaat' => 'required|unique:jemaats',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'daerah_id' => 'required|exists:data_daerah,id',
            'no_hp' => 'required|string|max:20',
            'link_lokasi' => 'nullable|url'
        ]);

        $jemaat = Jemaat::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Jemaat berhasil ditambahkan',
            'data' => $jemaat], 201);
    }

    public function update(Request $request, $id)
    {
        $jemaat = Jemaat::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:100',
            'alamat' => 'sometimes|string',
            'no_hp' => 'sometimes|string|max:20',
            'link_lokasi' => 'sometimes|nullable|url'
        ]);

        $jemaat->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Data jemaat berhasil diperbarui']);
    }
}
