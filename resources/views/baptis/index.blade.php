@extends('layouts.app')

@section('title', 'Baptis')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Permohonan Baptis</h5>
        <a href="{{ route('baptis.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($baptis as $key => $bapti)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bapti->nama }}</td>
                        <td>
                            {{ $bapti->tempat_lahir }}, 
                            {{ $bapti->tgl_lahir->format('d F Y') }}
                        </td>
                        <td>{{ $bapti->no_hp }}</td>
                        <td>
                            <span class="badge 
                                @if($bapti->status == 'menunggu') bg-warning
                                @elseif($bapti->status == 'diproses') bg-primary
                                @else bg-success @endif">
                                {{ ucfirst($bapti->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('baptis.edit', $bapti->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('baptis.show', $bapti->id) }}" 
                               class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('baptis.destroy', $bapti->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus data ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection