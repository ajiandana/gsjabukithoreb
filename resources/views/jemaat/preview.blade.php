<div class="row">
    <div class="col-md-4 text-center">
        <div class="bg-light rounded p-3 mb-3">
            <h4>{{ $jemaat->nama }}</h4>
            <p class="text-muted mb-1">Kode: {{ $jemaat->kode_jemaat }}</p>
            <p class="text-muted">{{ $jemaat->jenis_kelamin }}, {{ $jemaat->usia }} tahun</p>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-sm">
            <tr>
                <th width="30%">Tempat/Tgl Lahir</th>
                <td>{{ $jemaat->tempat_lahir }}, {{ $jemaat->tgl_lahir->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $jemaat->alamat }}</td>
            </tr>
            <tr>
                <th>Daerah</th>
                <td>{{ $jemaat->daerah->nama }}</td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td>{{ $jemaat->no_hp }}</td>
            </tr>
            <tr>
                <th>Link Lokasi</th>
                <td>
                    @if($jemaat->link_lokasi)
                        <a href="{{ $jemaat->link_lokasi }}" target="_blank" class="me-2">
                            <i class="bi bi-box-arrow-up-right"></i> Buka Peta
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ $jemaat->link_lokasi }}').then(() => alert('Link disalin!'))" 
                                class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>