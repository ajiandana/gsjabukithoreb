<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $segara = Event::segera()->get();
        $berlangsung = Event::berlangsung()->get();
        $selesai = Event::selesai()->get();
        
        return view('event.index', compact('segara', 'berlangsung', 'selesai'));
    }

    public function create()
    {
        return view('event.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:100',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'informasi' => 'required|string',
            'is_multi_day' => 'required|boolean',
            'tanggal_selesai' => 'nullable|required_if:is_multi_day,1|date|after_or_equal:tanggal'
        ]);

        $path = $request->file('gambar')->store('events', 'public');

        Event::create([
            'gambar' => $path,
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'tempat' => $request->tempat,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $this->determineStatus($request->tanggal),
            'informasi' => $request->informasi,
            'tanggal_selesai' => $request->is_multi_day ? $request->tanggal_selesai : $request->tanggal,
            'is_multi_day' => $request->is_multi_day ?? false,
            'status' => $status = $this->determineStatus(
                $request->tanggal,
                $request->tanggal_selesai,
                $request->is_multi_day
            )
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        return view('event.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:100',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'informasi' => 'required|string',
            'is_multi_day' => 'nullable|boolean',
            'tanggal_selesai' => 'nullable|required_if:is_multi_day,true|date|after_or_equal:tanggal'
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($event->gambar);
            $data['gambar'] = $request->file('gambar')->store('events', 'public');
        }

        $data['status'] = $this->determineStatus($request->tanggal);
        $data['tanggal_selesai'] = $request->is_multi_day ? $request->tanggal_selesai : $request->tanggal;
        // $data['is_multi_day'] = $request->is_multi_day ?? false;
        $data['is_multi_day'] = (bool)$request->is_multi_day;
        $data['status'] = $this->determineStatus(
            $request->tanggal, 
            $request->is_multi_day ? $request->tanggal_selesai : null
        );

        $event->update($data);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->gambar);
        $event->delete();
        
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!');
    }

    private function determineStatus($tanggal)
    {
        $today = now()->format('Y-m-d');
        $eventDate = date('Y-m-d', strtotime($tanggal));

        if ($eventDate < $today) {
            return 'selesai';
        } elseif ($eventDate == $today) {
            return 'berlangsung';
        }
        return 'segera';
    }
}