@extends('layouts.app')

@section('title', isset($departemen) ? 'Edit Departemen' : 'Tambah Departemen')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($departemen) ? 'Edit' : 'Tambah' }} Departemen</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($departemen) ? route('departemen.update', $departemen->id) : route('departemen.store') }}" method="POST">
                @csrf
                @if(isset($departemen)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Departemen*</label>
                            <input type="text" class="form-control" name="nama" value="{{ $departemen->nama ?? old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gembala</label>
                            <select class="form-select" name="pastoral_id">
                                <option value="">-- Pilih Gembala --</option>
                                @foreach($pastorals as $pastoral)
                                    <option value="{{ $pastoral->id }}" {{ (isset($departemen) && $departemen->pastoral_id == $pastoral->id) ? 'selected' : '' }}>
                                        {{ $pastoral->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Informasi</label>
                            <textarea class="form-control" name="informasi" rows="3">{{ $departemen->informasi ?? old('informasi') }}</textarea>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4">Kepengurusan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Ketua</label>
                            <select class="form-select" name="ketua_id">
                                <option value="">-- Pilih Ketua --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->ketua?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wakil</label>
                            <select class="form-select" name="wakil_id">
                                <option value="">-- Pilih Wakil --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->wakil?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sekretaris</label>
                            <select class="form-select" name="sekretaris_id">
                                <option value="">-- Pilih Sekretaris --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->sekretaris?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bendahara</label>
                            <select class="form-select" name="bendahara_id">
                                <option value="">-- Pilih Bendahara --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->bendahara?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection