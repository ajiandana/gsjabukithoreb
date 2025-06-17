@extends('layouts.app')

@section('title', 'Manajemen Event')
@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Daftar Event</h5>
                <a href="{{ route('event.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <ul class="nav nav-tabs" id="eventTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="segera-tab" data-bs-toggle="tab" data-bs-target="#segera" type="button" role="tab">
                        Segera <span class="badge bg-primary">{{ $segara->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="berlangsung-tab" data-bs-toggle="tab" data-bs-target="#berlangsung" type="button" role="tab">
                        Sekarang <span class="badge bg-success">{{ $berlangsung->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab">
                        Selesai <span class="badge bg-secondary">{{ $selesai->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="eventTabsContent">
                <!-- Tab Segera -->
                <div class="tab-pane fade show active" id="segera" role="tabpanel">
                    @if($segara->isEmpty())
                        <div class="alert alert-info">Tidak ada event yang akan datang</div>
                    @else
                        <div class="row">
                            @foreach($segara as $event)
                                @include('event.card', ['status' => 'segera'])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Berlangsung -->
                <div class="tab-pane fade" id="berlangsung" role="tabpanel">
                    @if($berlangsung->isEmpty())
                        <div class="alert alert-info">Tidak ada event yang berlangsung saat ini</div>
                    @else
                        <div class="row">
                            @foreach($berlangsung as $event)
                                @include('event.card', ['status' => 'berlangsung'])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Selesai -->
                <div class="tab-pane fade" id="selesai" role="tabpanel">
                    @if($selesai->isEmpty())
                        <div class="alert alert-info">Tidak ada event yang telah selesai</div>
                    @else
                        <div class="row">
                            @foreach($selesai as $event)
                                @include('event.card', ['status' => 'selesai'])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection