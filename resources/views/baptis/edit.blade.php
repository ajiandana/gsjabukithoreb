@extends('layouts.app')

@section('title', 'Edit')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Data Baptis</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('baptis.update', $bapti->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap*</label>
                    <input type="text" class="form-control" name="nama" 
                           value="{{ $bapti->nama }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ayah*</label>
                    <input type="text" class="form-control" name="nama_ayah" 
                           value="{{ $bapti->nama_ayah }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ibu*</label>
                    <input type="text" class="form-control" name="nama_ibu" 
                           value="{{ $bapti->nama_ibu }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir*</label>
                    <input type="text" class="form-control" name="tempat_lahir" 
                           value="{{ $bapti->tempat_lahir }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir*</label>
                    <input type="date" class="form-control" name="tgl_lahir" 
                           value="{{ $bapti->tgl_lahir->format('Y-m-d') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No HP*</label>
                    <input type="text" class="form-control" name="no_hp" 
                           value="{{ $bapti->no_hp }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status*</label>
                    <select class="form-select" name="status" required>
                        <option value="menunggu" {{ $bapti->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $bapti->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $bapti->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('baptis.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection