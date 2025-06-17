@extends('layouts.app')

@section('title', 'Pemberkatan Nikah')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pemberkatan Nikah</h5>
        <a href="{{ route('pemberkatan-nikah.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Data
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
                        <th>Calon Pengantin</th>
                        <th>Rencana Tahun</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemberkatan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>Pria:</strong> {{ $item->pria_nama }}<br>
                            <strong>Wanita:</strong> {{ $item->wanita_nama }}
                        </td>
                        <td>{{ $item->rencana_tahun }}</td>
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
                            <a href="{{ route('pemberkatan-nikah.edit', $item->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('pemberkatan-nikah.show', $item->id) }}" 
                               class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('pemberkatan-nikah.destroy', $item->id) }}" 
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