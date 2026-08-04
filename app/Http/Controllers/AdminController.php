<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Pengunjung;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'total_pengunjung' => Pengunjung::whereHas('antrians', function($q) use ($today) {
                $q->where('tanggal', $today);
            })->count(),
            'total_antrian'    => Antrian::where('tanggal', $today)->count(),
            'total_menunggu'   => Antrian::where('tanggal', $today)->where('status', 'Menunggu')->count(),
            'total_dipanggil'  => Antrian::where('tanggal', $today)->where('status', 'Dipanggil')->count(),
            'total_selesai'    => Antrian::where('tanggal', $today)->where('status', 'Selesai')->count(),
        ];

        $chartData = Antrian::selectRaw('layanan_id, count(*) as total')
            ->where('tanggal', $today)
            ->groupBy('layanan_id')
            ->with('layanan')
            ->get();

        return view('admin.dashboard', compact('stats', 'chartData'));
    }
}