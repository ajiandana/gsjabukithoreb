<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Pastoral;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'wakil_id' => 'nullable|exists:jemaats,id',
            'sekretaris_id' => 'nullable|exists:jemaats,id',
            'bendahara_id' => 'nullable|exists:jemaats,id',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $departemen = Departemen::create($request->only(['nama', 'pastoral_id', 'informasi']));

        // Handle slider images
        if ($request->hasFile('slider_images')) {
            $sliderImages = $this->handleSliderImages($request->file('slider_images'));
            $departemen->slider_images = $sliderImages;
            $departemen->save();
        }

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
            'informasi' => 'required|string',
            'ketua_id' => 'required|exists:jemaats,id',
            'wakil_id' => 'nullable|exists:jemaats,id',
            'sekretaris_id' => 'nullable|exists:jemaats,id',
            'bendahara_id' => 'nullable|exists:jemaats,id',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $departemen->update($request->only(['nama', 'pastoral_id', 'informasi']));

        // Handle slider images
        if ($request->hasFile('slider_images')) {
            // Delete old images
            if ($departemen->slider_images) {
                foreach ($departemen->slider_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $sliderImages = $this->handleSliderImages($request->file('slider_images'));
            $departemen->slider_images = $sliderImages;
            $departemen->save();
        }

        // Update pengurus
        $departemen->pengurus()->delete();
        $this->simpanPengurus($departemen, $request);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui!');
    }

    public function destroy(Departemen $departemen)
    {
        // Delete slider images
        if ($departemen->slider_images) {
            foreach ($departemen->slider_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus!');
    }

    public function deleteSliderImage(Request $request, Departemen $departemen)
    {
        $imageIndex = $request->input('image_index');
        $sliderImages = $departemen->slider_images ?? [];

        if (isset($sliderImages[$imageIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($sliderImages[$imageIndex]);
            
            // Remove from array
            unset($sliderImages[$imageIndex]);
            
            // Reindex array
            $sliderImages = array_values($sliderImages);
            
            // Update database
            $departemen->slider_images = $sliderImages;
            $departemen->save();
        }

        return response()->json(['success' => true]);
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

    private function handleSliderImages($images)
    {
        $sliderImages = [];
        
        foreach ($images as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('departemen/slider', $filename, 'public');
            $sliderImages[] = $path;
        }

        return $sliderImages;
    }
}
