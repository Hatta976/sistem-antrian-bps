@extends('layouts.app')

@section('title', 'Laporan Pelayanan - BPS Prabumulih')

@section('content')
<div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
    <h5 class="fw-bold mb-3">Filter Laporan Pelayanan</h5>
    <form action="{{ route('admin.laporan.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Jenis Layanan</label>
            <select name="layanan_id" class="form-select">
                <option value="">Semua Layanan</option>
                @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}" {{ request('layanan_id') == $layanan->id ? 'selected' : '' }}>
                        {{ $layanan->nama_layanan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
            <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="btn btn-danger fw-bold" target="_blank">
                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
            </a>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-3 p-4">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>No Antrean</th>
                    <th>Nama Pengunjung</th>
                    <th>Instansi</th>
                    <th>Layanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $row)
                <tr>
                    <td>{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td class="fw-bold">{{ $row->nomor_antrian }}</td>
                    <td>{{ $row->pengunjung->nama }}</td>
                    <td>{{ $row->pengunjung->instansi }}</td>
                    <td>{{ $row->layanan->nama_layanan }}</td>
                    <td><span class="badge bg-secondary">{{ $row->status }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3 text-muted">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $laporans->withQueryString()->links() }}
    </div>
</div>
@endsection