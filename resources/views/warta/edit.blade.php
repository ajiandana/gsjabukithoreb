@extends('layouts.app')

@section('title', 'Edit Warta')
@section('content')
    <h1>Edit Warta</h1>
    <form action="{{ route('warta.update', $warta->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $warta->judul) }}" required>
        </div>
        
        <div class="mb-3">
            <label>Gambar Saat Ini</label>
            @if($warta->gambar)
                <img src="{{ asset('storage/' . $warta->gambar) }}" 
                     class="img-thumbnail d-block mb-2" 
                     style="max-height: 200px">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="hapus_gambar" id="hapus_gambar">
                    <label class="form-check-label text-danger" for="hapus_gambar">
                        Hapus gambar ini
                    </label>
                </div>
            @else
                <p class="text-muted">Tidak ada gambar</p>
            @endif
        </div>
            
        <div class="mb-3">
            <label>Upload Gambar Baru (Opsional)</label>
            <input type="file" class="form-control" name="gambar">
            <small class="text-muted">Format: JPEG/PNG, Maksimal 5MB</small>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Penulis</label>
                <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $warta->penulis) }}" required>
            </div>
            <div class="col-md-3">
                <label>Bulan</label>
                <select name="bulan" class="form-control" required>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                        <option value="{{ $month }}" {{ $warta->bulan == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $warta->tahun) }}" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label>Isi Warta</label>
            <textarea name="isi" class="form-control" rows="8" required>{{ old('isi', $warta->isi) }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('warta.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection