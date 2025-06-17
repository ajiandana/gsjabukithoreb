@extends('layouts.app')

@section('title', isset($pastoral) ? 'Edit Pastoral' : 'Tambah Pastoral')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($pastoral) ? 'Edit' : 'Tambah' }} Data Pastoral</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($pastoral) ? route('pastoral.update', $pastoral->id) : route('pastoral.store') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($pastoral)) @method('PUT') @endif
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
                            <label class="form-label">User Akun (Opsional)</label>
                            <select name="user_id" class="form-select">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (isset($pastoral) && $pastoral->user_id == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap*</label>
                            <input type="text" class="form-control" name="nama" 
                                   value="{{ $pastoral->nama ?? old('nama') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir*</label>
                                <input type="text" class="form-control" name="tempat_lahir" 
                                       value="{{ $pastoral->tempat_lahir ?? old('tempat_lahir') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir*</label>
                                <input type="date" class="form-control" name="tgl_lahir" 
                                       value="{{ isset($pastoral) ? $pastoral->tgl_lahir->format('Y-m-d') : old('tgl_lahir') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin*</label>
                            <select class="form-select" name="jenis_kelamin" required>
                                <option value="Laki-laki" {{ (isset($pastoral) && $pastoral->jenis_kelamin == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ (isset($pastoral) && $pastoral->jenis_kelamin == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            @if(isset($pastoral) && $pastoral->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$pastoral->foto) }}" width="100" class="img-thumbnail">
                                    <small class="text-muted d-block">Foto saat ini</small>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status*</label>
                            <select class="form-select" name="status_pastoral_id" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ (isset($pastoral) && $pastoral->status_pastoral_id == $status->id) ? 'selected' : '' }}>
                                        {{ $status->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP*</label>
                            <input type="text" class="form-control" name="no_hp" 
                                   value="{{ $pastoral->no_hp ?? old('no_hp') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Lokasi (Opsional)</label>
                            <div class="input-group mb-3">
                                <input type="url" class="form-control" name="link_lokasi" 
                                       value="{{ $pastoral->link_lokasi ?? old('link_lokasi') }}"
                                       placeholder="https://maps.google.com/...">
                                @if(isset($pastoral) && $pastoral->link_lokasi)
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="copyLink('{{ $pastoral->link_lokasi }}')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bio (Max 1000 karakter)</label>
                            <textarea class="form-control" name="bio" rows="4">{{ $pastoral->bio ?? old('bio') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap*</label>
                    <textarea class="form-control" name="alamat" rows="3" required>{{ $pastoral->alamat ?? old('alamat') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('pastoral.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#bioEditor',
        plugins: 'lists link',
        toolbar: 'bold italic | bullist numlist | link',
        menubar: false
    });
</script>
@endpush