@extends('layouts.app')

@section('title', 'Daftar Daerah')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-tags"></i> Daftar Daerah
                <a href="{{ route('daerah.create') }}" class="btn btn-light btn-sm float-end">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr class="table-secondary">
                        <th width="5%">#</th>
                        <th>Nama Daerah</th>
                        <th>Keterangan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daerahs as $key => $daerah)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $daerah->nama }}</td>
                            <td>{{ $daerah->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('daerah.edit', $daerah->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('daerah.destroy', $daerah->id) }}" 
                                      method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i> Hapus
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