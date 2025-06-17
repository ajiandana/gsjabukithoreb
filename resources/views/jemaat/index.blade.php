@extends('layouts.app')

@section('title', 'Manajemen Jemaat')
@section('content')
    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Jemaat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <!-- Konten akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> Daftar Jemaat</h5>
                <a href="{{ route('jemaat.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Pencarian -->
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                        placeholder="Cari berdasarkan nama, kode, no HP, atau daerah..." 
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
            <!-- Filter Form -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label>Filter Daerah</label>
                        <select name="daerah_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Daerah</option>
                            @foreach($daerahs as $daerah)
                                <option value="{{ $daerah->id }}" {{ request('daerah_id') == $daerah->id ? 'selected' : '' }}>
                                    {{ $daerah->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Filter Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <a href="{{ route('jemaat.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(request('search'))
                <div class="alert alert-info mb-3">
                    Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('jemaat.index') }}" class="float-end">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Daerah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jemaats as $jemaat)
                            <tr>
                                <td>{{ $loop->iteration + ($jemaats->currentPage() - 1) * $jemaats->perPage() }}</td>
                                <td>{{ $jemaat->kode_jemaat }}</td>
                                <td>{{ $jemaat->nama }}</td>
                                <td>{{ $jemaat->usia }} tahun</td>
                                <td>{{ $jemaat->jenis_kelamin }}</td>
                                <td>{{ $jemaat->daerah->nama }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm preview-btn" data-id="{{ $jemaat->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('jemaat.edit', $jemaat->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('jemaat.destroy', $jemaat->id) }}" method="POST" class="d-inline">
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

            <!-- Pagination -->
            <div class="mt-3">
                {{ $jemaats->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>            
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Preview Modal
        $('.preview-btn').click(function() {
            const id = $(this).data('id');
            $('#previewContent').load(`/jemaat/${id}/preview`, function() {
                $('#previewModal').modal('show');
            });
        });
    });
</script>
@endpush