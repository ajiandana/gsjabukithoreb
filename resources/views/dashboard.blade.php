@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h1>

    <div class="row mb-4">
        <!-- Card User -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total User</h5>
                            <h2 class="mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="bi bi-people display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Warta -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Warta</h5>
                            <h2 class="mb-0">{{ $totalWarta }}</h2>
                        </div>
                        <i class="bi bi-newspaper display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('warta.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Jemaat -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Jemaat</h5>
                            <h2 class="mb-0">{{ $totalJemaat }}</h2>
                        </div>
                        <i class="bi bi-people-fill display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('jemaat.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Pastoral -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Data Pastoral</h5>
                            <h2 class="mb-0">{{ $totalPastoral }}</h2>
                        </div>
                        <i class="bi bi-person-badge display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('pastoral.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Ibadah Minggu -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Jadwal Ibadah</h5>
                            <h2 class="mb-0">{{ $totalIbadah }}</h2>
                        </div>
                        <i class="bi bi-calendar-event display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('jadwal-ibadah.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Departemen -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Departemen</h5>
                            <h2 class="mb-0">{{ $totalDepartemen }}</h2>
                        </div>
                        <i class="bi bi-buildings display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('departemen.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Event -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Kelas/Event</h5>
                            <h2 class="mb-0">{{ $totalEvent }}</h2>
                        </div>
                        <i class="bi bi-calendar-check display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('event.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Card Layanan -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card text-white" style="background-color: #6f42c1;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Permohonan Doa</h5>
                            <h2 class="mb-0">{{ $totalDoa }}</h2>
                        </div>
                        <i class="bi bi-pen display-4 opacity-50"></i>
                    </div>
                    <a href="{{ route('permohonan-doa.index') }}" class="text-white stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Two columns for latest content -->
    <div class="row">
        <!-- Latest Warta -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Warta Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($latestWarta->count() > 0)
                        <div class="list-group">
                            @foreach($latestWarta as $warta)
                                <a href="{{ route('warta.edit', $warta->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $warta->judul }}</h6>
                                        <small>{{ $warta->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-muted small">{{ Str::limit($warta->isi, 100) }}</p>
                                    <small class="text-muted">{{ $warta->penulis }} | {{ $warta->bulan }} {{ $warta->tahun }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">Belum ada warta tersedia</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection