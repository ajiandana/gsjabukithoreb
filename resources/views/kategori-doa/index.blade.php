@extends('layouts.app')

@section('title', 'Kategori Doa')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5>Daftar Kategori Doa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kategori-doa.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="nama" class="form-control" placeholder="Tambah kategori baru..." required>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->nama }}</td>
                    <td>
                        <form action="{{ route('kategori-doa.destroy', $kategori->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection