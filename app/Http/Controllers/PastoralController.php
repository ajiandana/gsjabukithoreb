<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pastoral;
use Illuminate\Http\Request;
use App\Models\StatusPastoral;
use Illuminate\Support\Facades\Storage;

class PastoralController extends Controller
{
    public function index()
    {
        $pastorals = Pastoral::with('status')->latest()->get();
        return view('pastoral.index', compact('pastorals'));
    }

    public function create()
    {
        $users = User::where('role', 'pastoral')->get();
        $statuses = StatusPastoral::all();
        return view('pastoral.form', compact('users', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'link_lokasi' => 'nullable|url',
            'status_pastoral_id' => 'required|exists:status_pastoral,id',
            'bio' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pastorals', 'public');
        }

        Pastoral::create($data);

        return redirect()->route('pastoral.index')->with('success', 'Data pastoral berhasil ditambahkan!');
    }

    public function preview(Pastoral $pastoral)
    {
        return view('pastoral.preview', compact('pastoral'));
    }

    public function edit(Pastoral $pastoral)
    {
        $users = User::where('role', 'pastoral')->get();
        $statuses = StatusPastoral::all();
        return view('pastoral.form', compact('pastoral', 'users', 'statuses'));
    }

    public function update(Request $request, Pastoral $pastoral)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'link_lokasi' => 'nullable|url',
            'status_pastoral_id' => 'required|exists:status_pastoral,id',
            'bio' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pastoral->foto) {
                Storage::disk('public')->delete($pastoral->foto);
            }
            $data['foto'] = $request->file('foto')->store('pastorals', 'public');
        }

        $pastoral->update($data);

        return redirect()->route('pastoral.index')->with('success', 'Data pastoral berhasil diperbarui!');
    }

    public function destroy(Pastoral $pastoral)
    {
        if ($pastoral->foto) {
            Storage::disk('public')->delete($pastoral->foto);
        }
        $pastoral->delete();
        return redirect()->route('pastoral.index')->with('success', 'Data pastoral berhasil dihapus!');
    }
}
