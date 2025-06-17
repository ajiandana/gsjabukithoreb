@extends('layouts.app')

@section('title', 'Jadwal Ibadah')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-calendar-event"></i> Jadwal Ibadah</h1>
        <a href="{{ route('jadwal-ibadah.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>
    <div>
        <p>
            Semua saudara yang bertugas pelayanan pada hari Minggu, baik pagi maupun sore, diwajibkan doa puasa pada hari Sabtu, kemudian bersama-sama berdoa pada pkl 17.30-18.15 di ruang tengah tempat ibadah bersama.
            Doa bersama Minggu pagi pkl. 07.15 - 07.45 WIB. Minggu sore, pkl 16.15 - 16.45 WIB.
            Berlaku juga bagi yang melayani Perjamuan Kudus dan Pelayanan Anak (Sekolah Minggu).
        </p>
    </div>

    <div class="row">
        @foreach($jadwals as $jadwal)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $jadwal->gambar) }}" class="img-fluid mb-3" style="max-height: 200px;">
                        <h5 class="card-title">{{ $jadwal->judul }} ({{ $jadwal->bulan }} {{ $jadwal->tahun }})</h5>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('jadwal-ibadah.download', $jadwal->id) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i> Unduh
                        </a>
                        <form action="{{ route('jadwal-ibadah.destroy', $jadwal->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>    
@endsection