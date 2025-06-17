@extends('layouts.app')

@section('title', 'Detail Departemen')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Departemen: {{ $departemen->nama }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Informasi Umum</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Nama Departemen</th>
                            <td>{{ $departemen->nama }}</td>
                        </tr>
                        <tr>
                            <th>Gembala</th>
                            <td>{{ $departemen->pastoral?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Informasi</th>
                            <td>{{ $departemen->informasi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h6>Kepengurusan</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Ketua</th>
                            <td>{{ $departemen->ketua?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Wakil</th>
                            <td>{{ $departemen->wakil?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sekretaris</th>
                            <td>{{ $departemen->sekretaris?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bendahara</th>
                            <td>{{ $departemen->bendahara?->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('departemen.edit', $departemen->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection