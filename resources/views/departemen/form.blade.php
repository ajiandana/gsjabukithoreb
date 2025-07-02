@extends('layouts.app')

@section('title', isset($departemen) ? 'Edit Departemen' : 'Tambah Departemen')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ isset($departemen) ? 'Edit' : 'Tambah' }} Departemen</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($departemen) ? route('departemen.update', $departemen->id) : route('departemen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($departemen)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Departemen*</label>
                            <input type="text" class="form-control" name="nama" value="{{ $departemen->nama ?? old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gembala</label>
                            <select class="form-select" name="pastoral_id">
                                <option value="">-- Pilih Gembala --</option>
                                @foreach($pastorals as $pastoral)
                                    <option value="{{ $pastoral->id }}" {{ (isset($departemen) && $departemen->pastoral_id == $pastoral->id) ? 'selected' : '' }}>
                                        {{ $pastoral->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Informasi</label>
                            <textarea class="form-control" name="informasi" rows="3">{{ $departemen->informasi ?? old('informasi') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Slider Images Section -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mt-3 mb-3">Slider Images</h5>
                        
                        @if(isset($departemen) && $departemen->slider_images)
                            <div class="mb-3">
                                <label class="form-label">Gambar Slider Saat Ini</label>
                                <div class="row" id="current-images">
                                    @foreach($departemen->slider_images as $index => $image)
                                        <div class="col-md-3 mb-2" id="image-{{ $index }}">
                                            <div class="card">
                                                <img src="{{ asset('storage/' . $image) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-2">
                                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="deleteSliderImage({{ $departemen->id }}, {{ $index }})">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar Slider Baru</label>
                            <input type="file" class="form-control" name="slider_images[]" multiple accept="image/*" onchange="previewImages(this)">
                            <small class="form-text text-muted">Pilih beberapa gambar sekaligus. Format: JPG, PNG, GIF. Maksimal 2MB per file.</small>
                        </div>

                        <div id="image-preview" class="row mb-3"></div>
                    </div>
                </div>

                <h5 class="mt-4">Kepengurusan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Ketua</label>
                            <select class="form-select" name="ketua_id">
                                <option value="">-- Pilih Ketua --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->ketua?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wakil</label>
                            <select class="form-select" name="wakil_id">
                                <option value="">-- Pilih Wakil --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->wakil?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sekretaris</label>
                            <select class="form-select" name="sekretaris_id">
                                <option value="">-- Pilih Sekretaris --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->sekretaris?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bendahara</label>
                            <select class="form-select" name="bendahara_id">
                                <option value="">-- Pilih Bendahara --</option>
                                @foreach($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ (isset($departemen) && $departemen->bendahara?->id == $jemaat->id) ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>

    <script>
        function previewImages(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (input.files) {
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-2';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            </div>
                        `;
                        preview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            }
        }

        function deleteSliderImage(departemenId, imageIndex) {
            if (confirm('Yakin ingin menghapus gambar ini?')) {
                fetch(`/departemen/${departemenId}/delete-slider-image`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        image_index: imageIndex
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${imageIndex}`).remove();
                        alert('Gambar berhasil dihapus!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus gambar');
                });
            }
        }
    </script>
@endsection