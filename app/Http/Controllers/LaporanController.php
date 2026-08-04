<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $layanans = Layanan::all();
        $query = Antrian::with(['pengunjung', 'layanan', 'user']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $laporans = $query->latest()->paginate(15);

        return view('admin.laporan.index', compact('laporans', 'layanans'));
    }

    public function exportPdf(Request $request)
    {
        $query = Antrian::with(['pengunjung', 'layanan', 'user']);
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $data = $query->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('data'));
        return $pdf->download('laporan-antrian-bps.pdf');
    }
}