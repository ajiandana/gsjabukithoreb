@extends('layouts.app')

@section('title', 'Manajemen Pastoral')
@section('content')
    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pastoral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <!-- Konten akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> Daftar Pastoral</h5>
                <a href="{{ route('pastoral.create') }}" class="btn btn-light btn-sm">
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
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pastorals as $key => $pastoral)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @if($pastoral->foto)
                                        <img src="{{ asset('storage/'.$pastoral->foto) }}" width="50" class="rounded-circle">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $pastoral->nama }}</td>
                                <td>{{ $pastoral->no_hp }}</td>
                                <td>
                                    <span class="badge bg-{{ $pastoral->status->nama == 'Aktif' ? 'success' : 'warning' }}">
                                        {{ $pastoral->status->nama }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm preview-btn" data-id="{{ $pastoral->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('pastoral.edit', $pastoral->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pastoral.destroy', $pastoral->id) }}" method="POST" class="d-inline">
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi preview
        $(document).on('click', '.preview-btn', function() {
            const id = $(this).data('id');
            console.log('Preview clicked for ID:', id); // Debugging
            
            $.ajax({
                url: `/pastoral/${id}/preview`,
                type: 'GET',
                success: function(data) {
                    $('#previewContent').html(data);
                    $('#previewModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Gagal memuat data. Pastikan ID pastoral valid.');
                }
            });
        });

        // Fungsi copy link (global)
        window.copyLink = function(link) {
            navigator.clipboard.writeText(link).then(() => {
                alert('Link berhasil disalin!');
            }).catch(() => {
                // Fallback untuk browser lama
                const textarea = document.createElement('textarea');
                textarea.value = link;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                alert('Link disalin!');
            });
        };
    });
</script>
@endpush