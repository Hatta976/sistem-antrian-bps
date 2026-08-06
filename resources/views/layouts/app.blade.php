<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Antrean BPS Kota Prabumulih')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --bps-blue: #003366; --bps-blue-light: #0059B3; }
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: var(--bps-blue); color: white; transition: all 0.3s; z-index: 100; }
        .main-content { margin-left: 260px; padding: 25px; }
        .navbar-custom { background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .bg-bps { background-color: var(--bps-blue) !important; color: white; }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar d-flex flex-column p-3">
        <!-- KODE BARU -->
    <div class="d-flex align-items-center mb-4 text-white text-decoration-none px-2">
    <img src="{{ asset('img/logobps.png') }}" alt="Logo BPS" style="height: 35px;" class="me-2">
    <span class="fs-5 fw-bold">PST BPS Prabumulih</span>
    </div>
        <hr class="text-secondary">
        <ul class="nav nav-pills flex-column mb-auto">
            @if(auth()->user()->isAdmin())
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white bg-bps">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link text-white">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan
                    </a>
                </li>
            @else
                <li class="nav-item mb-2">
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link text-white bg-bps">
                        <i class="bi bi-display me-2"></i> Dashboard Loket
                    </a>
                </li>
            @endif
            <li class="nav-item mb-2">
                <a href="{{ route('monitor.index') }}" target="_blank" class="nav-link text-white">
                    <i class="bi bi-tv me-2"></i> Layar Monitor (TV)
                </a>
            </li>
        </ul>
        <hr class="text-secondary">
        <div class="px-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light w-100 text-start"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand navbar-light navbar-custom rounded-3 mb-4 px-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 fs-6 text-secondary">Sistem Antrean Pelayanan Statistik Terpadu</span>
                <span class="badge bg-bps fs-6 px-3 py-2"><i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} ({{ auth()->user()->role->nama_role }})</span>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>