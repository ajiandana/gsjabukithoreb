@extends('layouts.app')

@section('title', 'Info Baptis')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Data Baptis</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Lengkap</th>
                        <td>{{ $bapti->nama }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ayah</th>
                        <td>{{ $bapti->nama_ayah }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ibu</th>
                        <td>{{ $bapti->nama_ibu }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>{{ $bapti->tempat_lahir }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Tanggal Lahir</th>
                        <td>{{ $bapti->tgl_lahir->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>{{ $bapti->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge 
                                @if($bapti->status == 'menunggu') bg-warning
                                @elseif($bapti->status == 'diproses') bg-primary
                                @else bg-success @endif">
                                {{ ucfirst($bapti->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $bapti->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('baptis.edit', $bapti->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('baptis.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection