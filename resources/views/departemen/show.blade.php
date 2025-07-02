@extends('layouts.app')

@section('title', 'Detail Departemen')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Departemen: {{ $departemen->nama }}</h5>
        </div>
        <div class="card-body">
            <!-- Slider Images -->
            @if($departemen->slider_images && count($departemen->slider_images) > 0)
                <div class="mb-4">
                    <h6>Slider Images</h6>
                    <div id="departemenSlider" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($departemen->slider_images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" style="height: 300px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if(count($departemen->slider_images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#departemenSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#departemenSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h6>Informasi Umum</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Nama Departemen</th>
                            <td>{{ $departemen->nama }}</td>
                        </tr>
                        <tr>
                            <th>Gembala</th>
                            <td>{{ $departemen->pastoral?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Informasi</th>
                            <td>{{ $departemen->informasi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h6>Kepengurusan</h6>
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Ketua</th>
                            <td>{{ $departemen->ketua?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Wakil</th>
                            <td>{{ $departemen->wakil?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sekretaris</th>
                            <td>{{ $departemen->sekretaris?->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bendahara</th>
                            <td>{{ $departemen->bendahara?->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('departemen.edit', $departemen->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection