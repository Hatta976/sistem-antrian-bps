@extends('layouts.app')

@section('title', 'Dashboard Admin - BPS Prabumulih')

@section('content')
<h4 class="fw-bold mb-4">Dashboard Analytics</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-3 border-start border-4 border-primary">
            <small class="text-muted font-weight-bold">PENGUNJUNG HARI INI</small>
            <h2 class="fw-bold mt-2 mb-0">{{ $stats['total_pengunjung'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-3 border-start border-4 border-warning">
            <small class="text-muted font-weight-bold">ANTEAN MENUNGGU</small>
            <h2 class="fw-bold mt-2 mb-0 text-warning">{{ $stats['total_menunggu'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-3 border-start border-4 border-info">
            <small class="text-muted font-weight-bold">SEDANG DIPANGGIL</small>
            <h2 class="fw-bold mt-2 mb-0 text-info">{{ $stats['total_dipanggil'] }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 bg-white p-3 border-start border-4 border-success">
            <small class="text-muted font-weight-bold">ANTEAN SELESAI</small>
            <h2 class="fw-bold mt-2 mb-0 text-success">{{ $stats['total_selesai'] }}</h2>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <h5 class="fw-bold mb-3">Statistik Kunjungan per Layanan Hari Ini</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Jenis Layanan</th>
                    <th class="text-center">Jumlah Antrean Hari Ini</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chartData as $item)
                <tr>
                    <td><span class="badge bg-primary fs-6">{{ $item->layanan->kode_layanan }}</span></td>
                    <td class="fw-bold">{{ $item->layanan->nama_layanan }}</td>
                    <td class="text-center fw-bold">{{ $item->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection