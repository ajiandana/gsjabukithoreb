@extends('layouts.app')

@section('title', 'Permohonan Doa')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5>Daftar Permohonan Doa</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="150px">Aksi</th> <!-- Lebar kolom disesuaikan -->
                </tr>
            </thead>
            <tbody>
                @foreach($permohonans as $permohonan)
                <tr>
                    <td>{{ $permohonan->nama }}</td>
                    <td>{{ $permohonan->kategori->nama }}</td>
                    <td>
                        <span class="badge 
                            @if($permohonan->status == 'pending') bg-warning
                            @elseif($permohonan->status == 'diproses') bg-info
                            @else bg-success @endif">
                            {{ ucfirst($permohonan->status) }}
                        </span>
                    </td>
                    <td>{{ $permohonan->created_at->format('d/m/Y') }}</td>
                    <td>
                        <!-- Tombol Update Status -->
                        <form action="{{ route('permohonan-doa.update-status', $permohonan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="{{ $permohonan->status == 'pending' ? 'diproses' : 'selesai' }}">
                            <button type="submit" class="btn btn-sm 
                                @if($permohonan->status == 'pending') btn-info
                                @elseif($permohonan->status == 'diproses') btn-success
                                @else btn-secondary disabled @endif">
                                @if($permohonan->status == 'pending') Proses
                                @elseif($permohonan->status == 'diproses') Selesai
                                @else Selesai @endif
                            </button>
                        </form>
        
                        <!-- Tombol Hapus -->
                        <form action="{{ route('permohonan-doa.destroy', $permohonan->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus permohonan ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection