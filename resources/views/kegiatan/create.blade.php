@extends('layouts.app')

@section('title', 'Tambah Kegiatan')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Kegiatan Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan*</label>
                    <input type="text" class="form-control" name="judul" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal*</label>
                    <input type="date" class="form-control" name="tanggal" 
                        value="{{ old('tanggal', isset($kegiatan) ? $kegiatan->tanggal->format('Y-m-d') : '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Gambar*</label>
                    <input type="file" class="form-control" name="gambar[]" multiple required id="gambar-upload">
                    <small class="text-muted">Bisa upload lebih dari 1 gambar (max 2MB per gambar)</small>
                </div>
                <div id="default-caption" class="mt-2">
                    <label class="form-label">Caption untuk semua gambar</label>
                    <input type="text" class="form-control" name="default_caption" 
                           placeholder="Caption akan berlaku untuk semua gambar (opsional)">
                </div>                
                <div id="caption-container" class="mb-3">
                    <!-- Dynamic caption fields akan muncul di sini -->
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('gambar-upload').addEventListener('change', function(e) {
            const container = document.getElementById('caption-container');
            container.innerHTML = '';
            
            Array.from(e.target.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'mb-3';
                div.innerHTML = `
                    <label class="form-label">Caption untuk: <strong>${file.name}</strong></label>
                    <input type="text" class="form-control" name="caption[]" 
                        placeholder="Masukkan caption untuk gambar ini (opsional)">
                `;
                container.appendChild(div);
            });
        });
    </script>
    @endpush
@endsection