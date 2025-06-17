<div class="row">
    <div class="col-md-4 text-center">
        @if($pastoral->foto)
            <img src="{{ asset('storage/'.$pastoral->foto) }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
        @else
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                <i class="bi bi-person text-white" style="font-size: 5rem;"></i>
            </div>
        @endif
        
        <h4>{{ $pastoral->nama }}</h4>
        <p class="text-muted">{{ $pastoral->status->nama }}</p>
    </div>
    <div class="col-md-8">
        <table class="table table-sm">
            <tr>
                <th width="30%">Tempat/Tgl Lahir</th>
                <td>{{ $pastoral->tempat_lahir }}, {{ $pastoral->tgl_lahir->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $pastoral->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td>{{ $pastoral->no_hp }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $pastoral->alamat }}</td>
            </tr>
            <tr>
                <th>Link Lokasi</th>
                <td>
                    @if($pastoral->link_lokasi)
                        <a href="{{ $pastoral->link_lokasi }}" target="_blank" class="me-2">
                            <i class="bi bi-box-arrow-up-right"></i> Buka
                        </a>
                        <button onclick="copyLink('{{ $pastoral->link_lokasi }}')" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>User Akun</th>
                <td>
                    @if($pastoral->user)
                        {{ $pastoral->user->email }}
                    @else
                        Tidak terhubung
                    @endif
                </td>
            </tr>
            <tr>
                <th>Bio</th>
                <td>{{ $pastoral->bio ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>