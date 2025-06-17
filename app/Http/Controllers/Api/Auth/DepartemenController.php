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
        // $departemen = Departemen::with([
        //     'pastoral:id,nama',
        //     'pengurus.jemaat:id,nama'
        // ])->get();

        // $result = $departemen->map(function ($item) {
        //     return [
        //         'nama' => $item->nama,
        //         'informasi' => $item->informasi,
        //         'pastoral' => $item->pastoral ? $item->pastoral->nama : null,
        //         'pengurus' => $item->pengurus->map(function ($p) {
        //             return [
        //                 'nama' => $p->jemaat->nama ?? null,
        //                 'jabatan' => $p->jabatan,
        //             ];
        //         })
        //     ];
        // });

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Daftar departemen berhasil diambil',
        //     'data' => $result
        // ]);
        $departemens = DB::table('departemens')
            ->leftJoin('pastorals', 'departemens.pastoral_id', '=', 'pastorals.id')
            ->select('departemens.id', 'departemens.nama as nama_departemen', 'departemens.informasi', 'pastorals.nama as gembala')
            ->get();

        foreach ($departemens as $departemen) {
            $pengurus = DB::table('pengurus_departemens')
                ->join('jemaats', 'pengurus_departemens.jemaat_id', '=', 'jemaats.id')
                ->where('pengurus_departemens.departemen_id', $departemen->id)
                ->select('jemaats.nama', 'pengurus_departemens.jabatan')
                ->get();
            $departemen->pengurus = $pengurus;
        }

        return response()->json([
            'status' => true,
            'data' => $departemens
        ]);
    }
}
