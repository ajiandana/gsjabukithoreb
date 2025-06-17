<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</head>
<body>
    @auth
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white vh-100 d-flex flex-column" style="width: 250px; position: fixed; overflow: hidden;">
            <h4 class="mb-4 text-center mt-4">Admin Gereja</h4>
            <div class="flex-grow-1 overflow-auto">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Manajemen User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('warta.index') }}" class="nav-link text-white {{ request()->routeIs('warta.*') ? 'active' : '' }}">
                            <i class="bi bi-newspaper me-2"></i> Warta Gereja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal-ibadah.index') }}" class="nav-link text-white {{ request()->routeIs('jadwal-ibadah.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event me-2"></i> Ibadah Minggu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('status-pastoral.index') }}" class="nav-link text-white {{ request()->routeIs('status-pastoral.*') ? 'active' : '' }}">
                            <i class="bi bi-tags me-2"></i> Status Pastoral
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pastoral.index') }}" class="nav-link text-white {{ request()->routeIs('pastoral.*') ? 'active' : '' }}">
                            <i class="bi bi-person-badge me-2"></i> Data Pastoral
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('daerah.index') }}" class="nav-link text-white {{ request()->routeIs('daerah.*') ? 'active' : '' }}">
                            <i class="bi bi-map me-2"></i> Daftar Daerah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jemaat.index') }}" class="nav-link text-white {{ request()->routeIs('jemaat.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Data Jemaat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('event.index') }}" class="nav-link text-white {{ request()->routeIs('event.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event me-2"></i> Kelas / Event
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('departemen.index') }}" class="nav-link text-white {{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                            <i class="bi bi-buildings me-2"></i> Departemen
                        </a>
                    </li>              
                    <li class="nav-item">
                        <a href="{{ route('kegiatan.index') }}" class="nav-link text-white {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                            <i class="bi bi-images me-2"></i> Galeri
                        </a>
                    </li>
                    <li class="nav-item sidebar-dropdown position-relative">
                        <a href="#" class="nav-link text-white 
                            {{ request()->routeIs('permohonan-doa.*') || 
                               request()->routeIs('kategori-doa.*') || 
                               request()->routeIs('baptis.*') || 
                               request()->routeIs('penyerahan-anak.*') || 
                               request()->routeIs('pemberkatan-nikah.*') ? 'active' : '' }}">
                            <i class="bi bi-pen me-2"></i> Layanan
                        </a>
                        <ul class="sidebar-submenu list-unstyled bg-dark">
                            <li>
                                <a href="{{ route('kategori-doa.index') }}" class="nav-link text-white">
                                    <i class="bi bi-tags me-2"></i> Kategori Doa
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('permohonan-doa.index') }}" class="nav-link text-white">
                                    <i class="bi bi-list-check me-2"></i> Permohonan Doa
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('baptis.index') }}" class="nav-link text-white">
                                    <i class="bi bi-list-check me-2"></i> Baptisan Air
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('penyerahan-anak.index') }}" class="nav-link text-white">
                                    <i class="bi bi-list-check me-2"></i> Penyerahan Anak
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pemberkatan-nikah.index') }}" class="nav-link text-white">
                                    <i class="bi bi-list-check me-2"></i> Pemberkatan Nikah
                                </a>
                            </li>
                        </ul>
                    </li>                    
                </ul>
            </div>
            <div class="pt-3 border-top p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        
        <div class="flex-grow-1 p-4" style="margin-left: 250px;">
            @yield('content')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.sidebar-submenu').hide();
            $('.sidebar-dropdown').hover(
                function() { $(this).find('.sidebar-submenu').show(); },
                function() { $(this).find('.sidebar-submenu').hide(); }
            );
        });
    </script>
    @endauth
</body>
</html>