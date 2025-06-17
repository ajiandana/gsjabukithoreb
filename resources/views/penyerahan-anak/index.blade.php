@extends('layouts.app')

@section('title', 'Penyerahan Anak')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Penyerahan Anak</h5>
        <a href="{{ route('penyerahan-anak.create') }}" class="btn btn-primary">
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
                        <th>Nama Anak</th>
                        <th>Orang Tua</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penyerahanAnak as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_anak }}</td>
                        <td>
                            <small class="d-block">Bp. {{ $item->nama_ayah }} & Ibu {{ $item->nama_ibu }}</small>
                        </td>
                        <td>{{ $item->no_hp }}</td>
                        <td>
                            <span class="badge 
                                @if($item->status == 'menunggu') bg-warning
                                @elseif($item->status == 'diproses') bg-primary
                                @else bg-success @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('penyerahan-anak.edit', $item->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('penyerahan-anak.show', $item->id) }}" 
                               class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('penyerahan-anak.destroy', $item->id) }}" 
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