@extends('layouts.app')

@section('title', 'Info Anak')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Penyerahan Anak</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Anak</th>
                        <td>{{ $penyerahanAnak->nama_anak }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ayah</th>
                        <td>{{ $penyerahanAnak->nama_ayah }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ibu</th>
                        <td>{{ $penyerahanAnak->nama_ibu }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">No HP</th>
                        <td>{{ $penyerahanAnak->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge 
                                @if($penyerahanAnak->status == 'menunggu') bg-warning
                                @elseif($penyerahanAnak->status == 'diproses') bg-primary
                                @else bg-success @endif">
                                {{ ucfirst($penyerahanAnak->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $penyerahanAnak->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('penyerahan-anak.edit', $penyerahanAnak->id) }}" class="btn btn-warning">
                <i class="bi bi-edit"></i> Edit
            </a>
            <a href="{{ route('penyerahan-anak.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection