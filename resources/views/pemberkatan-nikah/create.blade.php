@extends('layouts.app')

@section('title', 'Tambah Pemberkatan Nikah')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Tambah Pemberkatan Nikah</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pemberkatan-nikah.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Data Pria -->
                <div class="col-md-6 mb-4">
                    <h5 class="border-bottom pb-2">Data Calon Pria</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="pria_nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sudah Baptis?*</label>
                        <select class="form-select" name="pria_sudah_baptis" required>
                            <option value="1">Sudah</option>
                            <option value="0">Belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah*</label>
                        <input type="text" class="form-control" name="pria_ayah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu*</label>
                        <input type="text" class="form-control" name="pria_ibu" required>
                    </div>
                </div>

                <!-- Data Wanita -->
                <div class="col-md-6 mb-4">
                    <h5 class="border-bottom pb-2">Data Calon Wanita</h5>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="wanita_nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sudah Baptis?*</label>
                        <select class="form-select" name="wanita_sudah_baptis" required>
                            <option value="1">Sudah</option>
                            <option value="0">Belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah*</label>
                        <input type="text" class="form-control" name="wanita_ayah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu*</label>
                        <input type="text" class="form-control" name="wanita_ibu" required>
                    </div>
                </div>

                <!-- Data Pernikahan -->
                <div class="col-12 mb-4">
                    <h5 class="border-bottom pb-2">Data Pernikahan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rencana Tahun Pernikahan*</label>
                            <input type="number" class="form-control" name="rencana_tahun" 
                                   min="{{ date('Y') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP*</label>
                            <input type="text" class="form-control" name="no_hp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status*</label>
                            <select class="form-select" name="status" required>
                                <option value="menunggu">Menunggu</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('pemberkatan-nikah.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection