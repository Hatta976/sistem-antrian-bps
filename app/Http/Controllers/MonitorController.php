<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;

class MonitorController extends Controller
{
    public function index()
    {
        return view('monitor.index');
    }

    public function getData()
    {
        $today = Carbon::today()->toDateString();

        $antrianAktif = Antrian::with('layanan', 'pengunjung')
            ->where('tanggal', $today)
            ->where('status', 'Dipanggil')
            ->orderBy('waktu_panggil', 'desc')
            ->first();

        $nextAntrian = Antrian::with('layanan')
            ->where('tanggal', $today)
            ->where('status', 'Menunggu')
            ->orderBy('id', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'aktif' => $antrianAktif,
            'next'  => $nextAntrian
        ]);
    }
}