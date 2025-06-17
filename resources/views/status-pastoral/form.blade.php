@extends('layouts.app')

@section('title', isset($status) ? 'Edit Status' : 'Tambah Status')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($status) ? 'Edit' : 'Tambah' }} Status Pastoral</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($status) ? route('status-pastoral.update', $status->id) : route('status-pastoral.store') }}" 
                  method="POST">
                @csrf
                @if(isset($status)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama Status*</label>
                    <input type="text" class="form-control" name="nama" 
                           value="{{ $status->nama ?? old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3">{{ $status->keterangan ?? old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('status-pastoral.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection