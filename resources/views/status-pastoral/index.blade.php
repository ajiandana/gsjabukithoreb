@extends('layouts.app')

@section('title', 'Status Pastoral')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-tags"></i> Daftar Status Pastoral
                <a href="{{ route('status-pastoral.create') }}" class="btn btn-light btn-sm float-end">
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
                        <th>Nama Status</th>
                        <th>Keterangan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $key => $status)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $status->nama }}</td>
                            <td>{{ $status->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('status-pastoral.edit', $status->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('status-pastoral.destroy', $status->id) }}" 
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