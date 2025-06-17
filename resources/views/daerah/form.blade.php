@extends('layouts.app')

@section('title', isset($daerah) ? 'Edit Daerah' : 'Tambah Daerah')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($daerah) ? 'Edit' : 'Tambah' }} Status Pastoral</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($daerah) ? route('daerah.update', $daerah->id) : route('daerah.store') }}" 
                  method="POST">
                @csrf
                @if(isset($daerah)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama Daerah*</label>
                    <input type="text" class="form-control" name="nama" 
                           value="{{ $daerah->nama ?? old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" rows="3">{{ $daerah->keterangan ?? old('keterangan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('daerah.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection