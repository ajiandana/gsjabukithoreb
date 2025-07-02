<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DepartemenController extends Controller
{
    public function index(): JsonResponse
    {
        $departemens = DB::table('departemens')
            ->leftJoin('pastorals', 'departemens.pastoral_id', '=', 'pastorals.id')
            ->select(
                'departemens.id', 
                'departemens.nama as nama_departemen', 
                'departemens.informasi', 
                'departemens.slider_images',
                'pastorals.name as gembala'
            )
            ->get();

        foreach ($departemens as $departemen) {
            $pengurus = DB::table('pengurus_departemens')
                ->join('jemaats', 'pengurus_departemens.jemaat_id', '=', 'jemaats.id')
                ->where('pengurus_departemens.departemen_id', $departemen->id)
                ->select('jemaats.nama', 'pengurus_departemens.jabatan')
                ->get();
            $departemen->pengurus = $pengurus;

            $departemen->slider_images = $this->formatSliderImages($departemen->slider_images);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daftar departemen berhasil diambil',
            'data' => $departemens
        ]);
    }

    public function show($id): JsonResponse
    {
        $departemen = DB::table('departemens')
            ->leftJoin('pastorals', 'departemens.pastoral_id', '=', 'pastorals.id')
            ->where('departemens.id', $id)
            ->select(
                'departemens.id', 
                'departemens.nama as nama_departemen', 
                'departemens.informasi', 
                'departemens.slider_images',
                'pastorals.name as gembala'
            )
            ->first();

        if (!$departemen) {
            return response()->json([
                'status' => false,
                'message' => 'Departemen tidak ditemukan'
            ], 404);
        }

        $pengurus = DB::table('pengurus_departemens')
            ->join('jemaats', 'pengurus_departemens.jemaat_id', '=', 'jemaats.id')
            ->where('pengurus_departemens.departemen_id', $departemen->id)
            ->select('jemaats.nama', 'pengurus_departemens.jabatan')
            ->get();
        $departemen->pengurus = $pengurus;

        $departemen->slider_images = $this->formatSliderImages($departemen->slider_images);

        return response()->json([
            'status' => true,
            'message' => 'Detail departemen berhasil diambil',
            'data' => $departemen
        ]);
    }

    private function formatSliderImages($sliderImages)
    {
        if (!$sliderImages) {
            return [];
        }

        $images = json_decode($sliderImages, true);
        
        if (!is_array($images)) {
            return [];
        }

        return array_map(function ($image, $index) {
            return [
                'index' => $index,
                'url' => asset('storage/' . $image),
                'filename' => basename($image)
            ];
        }, $images, array_keys($images));
    }
}