@extends('layouts.app')

@section('content')
    <h1>Tambah User Baru</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="pastoral">Pastoral</option>
                <option value="jemaat">Jemaat</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection