@extends('layouts.app')

@section('title', 'Edit')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Pemberkatan Nikah</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pemberkatan-nikah.update', $pemberkatanNikah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Data Pria -->
                <div class="col-md-6 mb-4">
                    <h5 class="border-bottom pb-2">Data Calon Pria</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="pria_nama" 
                               value="{{ $pemberkatanNikah->pria_nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sudah Baptis?*</label>
                        <select class="form-select" name="pria_sudah_baptis" required>
                            <option value="1" {{ $pemberkatanNikah->pria_sudah_baptis ? 'selected' : '' }}>Sudah</option>
                            <option value="0" {{ !$pemberkatanNikah->pria_sudah_baptis ? 'selected' : '' }}>Belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah*</label>
                        <input type="text" class="form-control" name="pria_ayah" 
                               value="{{ $pemberkatanNikah->pria_ayah }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu*</label>
                        <input type="text" class="form-control" name="pria_ibu" 
                               value="{{ $pemberkatanNikah->pria_ibu }}" required>
                    </div>
                </div>

                <!-- Data Wanita -->
                <div class="col-md-6 mb-4">
                    <h5 class="border-bottom pb-2">Data Calon Wanita</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="wanita_nama" 
                               value="{{ $pemberkatanNikah->wanita_nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sudah Baptis?*</label>
                        <select class="form-select" name="wanita_sudah_baptis" required>
                            <option value="1" {{ $pemberkatanNikah->wanita_sudah_baptis ? 'selected' : '' }}>Sudah</option>
                            <option value="0" {{ !$pemberkatanNikah->wanita_sudah_baptis ? 'selected' : '' }}>Belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah*</label>
                        <input type="text" class="form-control" name="wanita_ayah" 
                               value="{{ $pemberkatanNikah->wanita_ayah }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu*</label>
                        <input type="text" class="form-control" name="wanita_ibu" 
                               value="{{ $pemberkatanNikah->wanita_ibu }}" required>
                    </div>
                </div>

                <!-- Data Pernikahan -->
                <div class="col-12 mb-4">
                    <h5 class="border-bottom pb-2">Data Pernikahan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rencana Tahun Pernikahan*</label>
                            <input type="number" class="form-control" name="rencana_tahun" 
                                   value="{{ $pemberkatanNikah->rencana_tahun }}" 
                                   min="{{ date('Y') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP*</label>
                            <input type="text" class="form-control" name="no_hp" 
                                   value="{{ $pemberkatanNikah->no_hp }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status*</label>
                            <select class="form-select" name="status" required>
                                <option value="menunggu" {{ $pemberkatanNikah->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pemberkatanNikah->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pemberkatanNikah->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('pemberkatan-nikah.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection