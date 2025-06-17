@extends('layouts.app')

@section('title', 'Galeri Kegiatan')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-images"></i> Daftar Kegiatan</h5>
                <a href="{{ route('kegiatan.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                @foreach($kegiatans as $kegiatan)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div id="carousel-{{ $kegiatan->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" style="height: 200px;">
                                    @foreach($kegiatan->galeri as $key => $gambar)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $gambar->gambar) }}" class="d-block w-100" style="object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $kegiatan->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $kegiatan->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $kegiatan->judul }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}
                                    </small>
                                </p>
                                <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection