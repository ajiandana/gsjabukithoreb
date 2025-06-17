<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Daerah;
use App\Models\Jemaat;
use Illuminate\Http\Request;

class JemaatController extends Controller
{
    public function index(Request $request)
    {
        $daerahs = Daerah::all();
        $query = Jemaat::with('daerah')->latest();

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('kode_jemaat', 'like', "%$search%")
                ->orWhere('no_hp', 'like', "%$search%")
                ->orWhereHas('daerah', function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                });
            });
        }
        // Filter
        if ($request->has('daerah_id') && $request->daerah_id != '') {
            $query->where('daerah_id', $request->daerah_id);
        }
        
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $jemaats = $query->paginate(10)->withQueryString();
        
        return view('jemaat.index', compact('jemaats', 'daerahs'));
    }

    public function create()
    {
        $daerahs = Daerah::all();
        return view('jemaat.form', compact('daerahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jemaat' => 'required|string|max:20|unique:jemaats',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'daerah_id' => 'required|exists:daerah,id',
            'no_hp' => 'required|string|max:15',
            'link_lokasi' => 'nullable|url'
        ]);
        // Konversi format tanggal
        $data = $request->all();
        $data['tgl_lahir'] = Carbon::parse($request->tgl_lahir);

        Jemaat::create($data);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil ditambahkan!');
    }

    public function show(Jemaat $jemaat)
    {
        //
    }

    public function edit(Jemaat $jemaat)
    {
        $daerahs = Daerah::all();
        return view('jemaat.form', compact('jemaat', 'daerahs'));
    }

    public function update(Request $request, Jemaat $jemaat)
    {
        $request->validate([
            'kode_jemaat' => 'required|string|max:20|unique:jemaats,kode_jemaat,'.$jemaat->id,
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'daerah_id' => 'required|exists:daerah,id',
            'no_hp' => 'required|string|max:15',
            'link_lokasi' => 'nullable|url'
        ]);

        $data = $request->all();
        $data['tgl_lahir'] = Carbon::parse($request->tgl_lahir);

        $jemaat->update($data);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil diperbarui!');
    }

    public function destroy(Jemaat $jemaat)
    {
        $jemaat->delete();
        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil dihapus!');
    }

    public function preview(Jemaat $jemaat)
    {
        return view('jemaat.preview', compact('jemaat'));
    }
}
