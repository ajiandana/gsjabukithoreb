@extends('layouts.app')

@section('title', 'Info Pasangan')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Pemberkatan Nikah</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Data Pria -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Data Calon Pria</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nama Lengkap</th>
                                <td>{{ $pemberkatanNikah->pria_nama }}</td>
                            </tr>
                            <tr>
                                <th>Status Baptis</th>
                                <td>
                                    <span class="badge {{ $pemberkatanNikah->pria_sudah_baptis ? 'bg-success' : 'bg-warning' }}">
                                        {{ $pemberkatanNikah->pria_sudah_baptis ? 'Sudah Baptis' : 'Belum Baptis' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>{{ $pemberkatanNikah->pria_ayah }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>{{ $pemberkatanNikah->pria_ibu }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data Wanita -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-pink text-white">
                        <h6 class="mb-0">Data Calon Wanita</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Nama Lengkap</th>
                                <td>{{ $pemberkatanNikah->wanita_nama }}</td>
                            </tr>
                            <tr>
                                <th>Status Baptis</th>
                                <td>
                                    <span class="badge {{ $pemberkatanNikah->wanita_sudah_baptis ? 'bg-success' : 'bg-warning' }}">
                                        {{ $pemberkatanNikah->wanita_sudah_baptis ? 'Sudah Baptis' : 'Belum Baptis' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>{{ $pemberkatanNikah->wanita_ayah }}</td>
                            </tr>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>{{ $pemberkatanNikah->wanita_ibu }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data Pernikahan -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-purple text-white">
                        <h6 class="mb-0">Data Pernikahan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="50%">Rencana Tahun</th>
                                        <td>{{ $pemberkatanNikah->rencana_tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>No HP</th>
                                        <td>{{ $pemberkatanNikah->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge 
                                                @if($pemberkatanNikah->status == 'menunggu') bg-warning
                                                @elseif($pemberkatanNikah->status == 'diproses') bg-primary
                                                @else bg-success @endif">
                                                {{ ucfirst($pemberkatanNikah->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Tanggal Dibuat</th>
                                        <td>{{ $pemberkatanNikah->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diupdate</th>
                                        <td>{{ $pemberkatanNikah->updated_at->format('d F Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('pemberkatan-nikah.edit', $pemberkatanNikah->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Data
            </a>
            <div>
                <a href="{{ route('pemberkatan-nikah.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Kembali ke Daftar
                </a>
                <form action="{{ route('pemberkatan-nikah.destroy', $pemberkatanNikah->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data ini?')">
                        <i class="fas fa-trash"></i> Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-pink {
        background-color: #e83e8c;
    }
    .bg-purple {
        background-color: #6f42c1;
    }
</style>
@endsection