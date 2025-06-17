<div class="col-md-4 mb-4">
    <div class="card h-100 @if($status == 'selesai') bg-light @endif">
        @if($status == 'berlangsung')
            <div class="ribbon ribbon-top bg-success">SEKARANG</div>
        @endif
        <img src="{{ asset('storage/' . $event->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">{{ $event->judul }}</h5>
            <p class="card-text">
                <i class="bi bi-calendar"></i> 
                    @if($event->is_multi_day && $event->tanggal_selesai)
                        {{ $event->tanggal->format('d M') }} - {{ $event->tanggal_selesai->format('d M Y') }}
                    @else
                        {{ $event->tanggal->format('d M Y') }}
                    @endif
                <br>
                <i class="bi bi-clock"></i> {{ date('H:i', strtotime($event->jam_mulai)) }} - {{ date('H:i', strtotime($event->jam_selesai)) }}<br>
                <i class="bi bi-geo-alt"></i> {{ $event->tempat }}
            </p>
            <p class="card-text">{{ Str::limit($event->informasi, 100) }}</p>
        </div>
        
        <div class="card-footer bg-transparent d-flex justify-content-between">
            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('event.destroy', $event->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>