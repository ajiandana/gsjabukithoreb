@extends('layouts.app')

@section('title', 'Tambah Jadwal Ibadah')
@section('content')
    <h1><i class="bi bi-calendar-plus"></i> Tambah Jadwal Ibadah</h1>
    
    <form action="{{ route('jadwal-ibadah.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>
        
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Jadwal (Max 2MB)</label>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg, image/png" required>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="bulan" class="form-label">Bulan</label>
                <select class="form-select" id="bulan" name="bulan" required>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" min="2020" max="2100" value="{{ date('Y') }}" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>
@endsection