@extends('layouts.app')

@section('title', isset($jemaat) ? 'Edit Jemaat' : 'Tambah Jemaat')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($jemaat) ? 'Edit' : 'Tambah' }} Data Jemaat</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($jemaat) ? route('jemaat.update', $jemaat->id) : route('jemaat.store') }}" method="POST">
                @csrf
                @if(isset($jemaat)) @method('PUT') @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kode Jemaat*</label>
                            <input type="text" class="form-control" name="kode_jemaat" 
                                   value="{{ $jemaat->kode_jemaat ?? old('kode_jemaat') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap*</label>
                            <input type="text" class="form-control" name="nama" 
                                   value="{{ $jemaat->nama ?? old('nama') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir*</label>
                                <input type="text" class="form-control" name="tempat_lahir" 
                                       value="{{ $jemaat->tempat_lahir ?? old('tempat_lahir') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir*</label>
                                <input type="date" class="form-control" name="tgl_lahir" 
                                    value="{{ old('tgl_lahir', isset($jemaat) ? $jemaat->tgl_lahir->format('Y-m-d') : '') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin*</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="Laki-laki" {{ (isset($jemaat) && $jemaat->jenis_kelamin == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ (isset($jemaat) && $jemaat->jenis_kelamin == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Daerah*</label>
                            <select class="form-select" name="daerah_id" required>
                                @foreach($daerahs as $daerah)
                                    <option value="{{ $daerah->id }}" {{ (isset($jemaat) && $jemaat->daerah_id == $daerah->id) ? 'selected' : '' }}>
                                        {{ $daerah->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP*</label>
                            <input type="text" class="form-control" name="no_hp" 
                                   value="{{ $jemaat->no_hp ?? old('no_hp') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap*</label>
                    <textarea class="form-control" name="alamat" rows="3" required>{{ $jemaat->alamat ?? old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link Lokasi (Opsional)</label>
                    <input type="url" class="form-control" name="link_lokasi" 
                           value="{{ $jemaat->link_lokasi ?? old('link_lokasi') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('jemaat.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection