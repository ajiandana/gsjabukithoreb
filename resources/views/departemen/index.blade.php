@extends('layouts.app')

@section('title', 'Manajemen Departemen')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-building"></i> Daftar Departemen</h5>
                <a href="{{ route('departemen.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Departemen</th>
                            <th>Gembala</th>
                            <th>Ketua</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departemens as $departemen)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $departemen->nama }}</td>
                                <td>{{ $departemen->pastoral?->nama ?? '-' }}</td>
                                <td>{{ $departemen->ketua?->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('departemen.edit', ['departemen' => $departemen->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('departemen.show', ['departemen' => $departemen->id]) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('departemen.destroy', ['departemen' => $departemen->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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