@extends('layouts.app')

@section('title', 'Warta')
@section('content')
    <h1>Daftar Warta</h1>
    <a href="{{ route('warta.create') }}" class="btn btn-primary mb-3">Tambah Warta</a>
    
    <div class="row">
        @foreach($wartas as $warta)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($warta->gambar)
                        <img src="{{ asset('storage/' . $warta->gambar) }}" 
                            class="card-img-top" 
                            style="height: 180px; object-fit: cover;"
                            alt="{{ $warta->judul }}">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" 
                            style="height: 180px;">
                            <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $warta->judul }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Oleh: {{ $warta->penulis }} | {{ $warta->bulan }} {{ $warta->tahun }}
                            </small>
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('warta.edit', $warta->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('warta.destroy', $warta->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Yakin ingin menghapus warta ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection