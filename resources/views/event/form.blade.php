@extends('layouts.app')

@section('title', isset($event) ? 'Edit Event' : 'Tambah Event')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($event) ? 'Edit' : 'Tambah' }} Event</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($event) ? route('event.update', $event->id) : route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($event)) @method('PUT') @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Gambar*</label>
                            <input type="file" class="form-control" name="gambar" {{ !isset($event) ? 'required' : '' }}>
                            @if(isset($event))
                                <img src="{{ asset('storage/' . $event->gambar) }}" width="100" class="mt-2">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul*</label>
                            <input type="text" class="form-control" name="judul" value="{{ $event->judul ?? old('judul') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal*</label>
                            <input type="date" class="form-control" name="tanggal" 
                                value="{{ old('tanggal', isset($event) ? $event->tanggal->format('Y-m-d') : '') }}" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="hidden" name="is_multi_day" value="0">
                            <input type="checkbox" class="form-check-input" name="is_multi_day" id="is_multi_day" value="1"
                                   {{ (isset($event) && $event->is_multi_day) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_multi_day">Event Multi Hari</label>
                        </div>
                        <div id="multi_day_fields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai*</label>
                                <input type="date" class="form-control" name="tanggal_selesai" 
                                    value="{{ old('tanggal_selesai', isset($event) ? $event->tanggal_selesai->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tempat*</label>
                            <input type="text" class="form-control" name="tempat" value="{{ $event->tempat ?? old('tempat') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jam Mulai*</label>
                                <input type="time" class="form-control" name="jam_mulai" value="{{ $event->jam_mulai ?? old('jam_mulai') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jam Selesai*</label>
                                <input type="time" class="form-control" name="jam_selesai" value="{{ $event->jam_selesai ?? old('jam_selesai') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Informasi*</label>
                    <textarea class="form-control" name="informasi" rows="5" required>{{ $event->informasi ?? old('informasi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('event.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi
        toggleMultiDayFields($('#is_multi_day').is(':checked'));
        
        $('#is_multi_day').change(function() {
            toggleMultiDayFields(this.checked);
        });
        
        function toggleMultiDayFields(isVisible) {
            if(isVisible) {
                $('#multi_day_fields').show();
                $('[name="tanggal_selesai"]').prop('required', true);
            } else {
                $('#multi_day_fields').hide();
                $('[name="tanggal_selesai"]').prop('required', false);
            }
        }
    });
</script>
@endpush