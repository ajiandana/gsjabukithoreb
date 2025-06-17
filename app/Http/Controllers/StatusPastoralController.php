<?php

namespace App\Http\Controllers;

use App\Models\StatusPastoral;
use Illuminate\Http\Request;

class StatusPastoralController extends Controller
{
    public function index()
    {
        $statuses = StatusPastoral::latest()->get();
        return view('status-pastoral.index', compact('statuses'));
    }

    public function create()
    {
        return view('status-pastoral.form');
    }

    public function edit($id)
    {
        $status = StatusPastoral::findOrFail($id);
        return view('status-pastoral.form', compact('status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:status_pastoral',
            'keterangan' => 'nullable|string'
        ]);

        StatusPastoral::create($request->all());
        return redirect()->route('status-pastoral.index')
           ->with('success', 'Status berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:status_pastoral,nama,'.$id,
            'keterangan' => 'nullable|string'
        ]);

        $status = StatusPastoral::findOrFail($id);
        $status->update($request->all());
        
        return redirect()->route('status-pastoral.index')
           ->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $status = StatusPastoral::findOrFail($id);

        if (!$status) {
            return redirect()->back()->with('error', 'Status tidak ditemukan!');
        }

        $status->delete();
        return redirect()->route('status-pastoral.index')
               ->with('success', 'Status berhasil dihapus!');
    }
}