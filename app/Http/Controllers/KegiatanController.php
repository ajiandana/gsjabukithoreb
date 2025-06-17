<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::with('galeri')->latest()->get();
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg|max:5012',
            'caption.*' => 'nullable|string|max:200' // Validasi caption
        ]);
    
        // Simpan kegiatan
        $kegiatan = Kegiatan::create($request->only('judul', 'deskripsi', 'tanggal'));
    
        // Simpan multiple gambar dengan caption
        if($request->hasFile('gambar')) {
            foreach($request->file('gambar') as $key => $file) {
                $path = $file->store('galeri', 'public');
                
                Galeri::create([
                    'kegiatan_id' => $kegiatan->id,
                    'gambar' => $path,
                    'caption' => $request->default_caption ?? null
                ]);
            }
        }
    
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5012',
            'caption.*' => 'nullable|string|max:200',
            'existing_caption' => 'nullable|array'
        ]);

        // Update data kegiatan
        $kegiatan->update($request->only('judul', 'deskripsi', 'tanggal'));

        // Update caption gambar yang sudah ada
        if ($request->has('existing_caption')) {
            foreach ($request->existing_caption as $id => $caption) {
                Galeri::where('id', $id)->update(['caption' => $caption]);
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $key => $file) {
                $path = $file->store('galeri', 'public');
                
                Galeri::create([
                    'kegiatan_id' => $kegiatan->id,
                    'gambar' => $path,
                    'caption' => $request->caption[$key] ?? null
                ]);
            }
        }

        return redirect()->route('kegiatan.show', $kegiatan->id)
               ->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        foreach ($kegiatan->galeri as $gambar) {
            if ($gambar->gambar && Storage::disk('public')->exists($gambar->gambar)) {
                Storage::disk('public')->delete($gambar->gambar);
            }
            $gambar->delete();
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function destroyImage(Galeri $gambar)
    {
        try {
            if ($gambar->gambar && Storage::disk('public')->exists($gambar->gambar)) {
                Storage::disk('public')->delete($gambar->gambar);
            }

            $gambar->delete();
            
            return back()->with('success', 'Gambar berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus gambar: '.$e->getMessage());
        }
    }
}
