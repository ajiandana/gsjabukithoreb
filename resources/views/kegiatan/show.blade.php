@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Kegiatan: {{ $kegiatan->judul }}</h5>
        <span class="badge bg-light text-primary">
            {{ $kegiatan->tanggal->isFuture() ? 'Akan Datang' : 'Selesai' }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Informasi Kegiatan -->
            <div class="col-md-8">
                <div class="mb-4">
                    <h6 class="text-secondary">Deskripsi Kegiatan</h6>
                    <p class="fs-6">{{ $kegiatan->deskripsi ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-secondary">Tanggal Kegiatan</h6>
                    <p class="fs-6"><i class="bi bi-calendar-event me-2"></i>{{ $kegiatan->tanggal->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Galeri Kegiatan -->
            <div class="col-md-4">
                <div class="card border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Galeri Kegiatan</h6>
                    </div>
                    <div class="card-body">
                        @if($kegiatan->galeri->count())
                            <div class="row">
                                @foreach($kegiatan->galeri as $gambar)
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border shadow-sm">
                                            <div class="gallery-img-wrapper">
                                                <img src="{{ asset('storage/' . $gambar->gambar) }}"
                                                     class="card-img-top gallery-img"
                                                     alt="Galeri {{ $kegiatan->judul }}">
                                            </div>
                                            <div class="card-body p-2">
                                                <small class="text-muted d-block mb-1">
                                                    {{ $gambar->caption ?: 'Tanpa caption' }}
                                                </small>
                                            </div>
                                            <div class="card-footer bg-transparent border-0 p-2">
                                                <form action="{{ route('galeri.destroy', $gambar->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                            onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Belum ada galeri untuk kegiatan ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <div>
                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning me-2" title="Edit Kegiatan">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')" title="Hapus Kegiatan">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Style untuk galeri hover -->
<style>
    .gallery-img-wrapper {
        overflow: hidden;
        height: 160px;
        border-radius: 5px;
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-img-wrapper:hover .gallery-img {
        transform: scale(1.05);
    }
</style>
@endsection
