@extends('layouts.app')

@section('title', 'Edit Kegiatan')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Kegiatan: {{ $kegiatan->judul }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan*</label>
                    <input type="text" class="form-control" name="judul" value="{{ $kegiatan->judul }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3">{{ $kegiatan->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal*</label>
                    <input type="date" class="form-control" name="tanggal" 
                           value="{{ $kegiatan->tanggal->format('Y-m-d') }}" required>
                </div>

                <h5 class="mt-4">Gambar Saat Ini</h5>
                <div class="row mb-4">
                    @foreach($kegiatan->galeri as $gambar)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $gambar->gambar) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <input type="text" class="form-control mb-2" 
                                        name="existing_caption[{{ $gambar->id }}]" 
                                        value="{{ $gambar->caption }}" placeholder="Caption gambar">
                                    <button type="button" class="btn btn-danger btn-sm w-100" 
                                            onclick="confirmDeleteImage({{ $gambar->id }})">
                                        <i class="bi bi-trash"></i> Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="form-label">Tambah Gambar Baru (Opsional)</label>
                    <input type="file" class="form-control" name="gambar[]" multiple id="gambar-upload">
                    <small class="text-muted">Bisa upload lebih dari 1 gambar (max 2MB per gambar)</small>
                </div>

                <div id="caption-container" class="mb-3">
                    <!-- Dynamic caption fields akan muncul di sini -->
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </form>

            <form id="delete-image-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Dynamic caption fields untuk gambar baru
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

        // Konfirmasi hapus gambar
        function confirmDeleteImage(id) {
            if (confirm('Yakin ingin menghapus gambar ini?')) {
                const form = document.getElementById('delete-image-form');
                form.action = `/galeri/${id}`;
                form.submit();
            }
        }
    </script>
    @endpush
@endsection