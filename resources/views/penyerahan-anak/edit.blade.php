@extends('layouts.app')

@section('title', 'Edit')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Penyerahan Anak</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('penyerahan-anak.update', $penyerahanAnak->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Anak*</label>
                    <input type="text" class="form-control" name="nama_anak" 
                           value="{{ $penyerahanAnak->nama_anak }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ayah*</label>
                    <input type="text" class="form-control" name="nama_ayah" 
                           value="{{ $penyerahanAnak->nama_ayah }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ibu*</label>
                    <input type="text" class="form-control" name="nama_ibu" 
                           value="{{ $penyerahanAnak->nama_ibu }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No HP yang bisa dihubungi*</label>
                    <input type="text" class="form-control" name="no_hp" 
                           value="{{ $penyerahanAnak->no_hp }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status*</label>
                    <select class="form-select" name="status" required>
                        <option value="menunggu" {{ $penyerahanAnak->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $penyerahanAnak->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $penyerahanAnak->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('penyerahan-anak.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection