@extends('layouts.app')

@section('content')
    <h1>Tambah Warta Baru</h1>
    <form action="{{ route('warta.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>
        
        <div class="mb-3">
            <label>Gambar (Maks 2MB)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Penulis</label>
                <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}" required>
            </div>
            <div class="col-md-3">
                <label>Bulan</label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                        <option value="{{ $month }}" {{ old('bulan') == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" required>
            </div>
        </div>
        
        <div class="mb-3">
            <label>Isi Warta</label>
            <textarea name="isi" class="form-control" rows="8" required>{{ old('isi') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('warta.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection