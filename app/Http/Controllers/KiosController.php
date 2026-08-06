<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KiosController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();

        return view('kios.index', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
        ]);

        $today = Carbon::today()->toDateString();
        $layanan = Layanan::findOrFail($request->layanan_id);

        // Menentukan Kode Huruf (A untuk layanan 1, B untuk layanan 2, dst)
        if (!empty($layanan->kode_layanan)) {
            $prefix = strtoupper($layanan->kode_layanan);
        } elseif (!empty($layanan->kode)) {
            $prefix = strtoupper($layanan->kode);
        } else {
            $allIds = Layanan::pluck('id')->toArray();
            $index = array_search($layanan->id, $allIds);
            $prefix = chr(65 + ($index !== false ? $index : 0));
        }

        // Hitung jumlah antrean khusus untuk layanan ini pada hari ini
        $lastAntrian = Antrian::where('tanggal', $today)
            ->where('layanan_id', $layanan->id)
            ->count();

        // Format nomor antrean (misal: B-001)
        $nomorUrut = str_pad($lastAntrian + 1, 3, '0', STR_PAD_LEFT);
        $nomorAntrian = $prefix . '-' . $nomorUrut;

        // Simpan ke database dan tampung ke variabel $antrian
        $antrian = Antrian::create([
            'layanan_id'    => $layanan->id,
            'nomor_antrian' => $nomorAntrian,
            'tanggal'       => $today,
            'status'        => 'Menunggu',
        ]);

        // Arahkan langsung ke halaman cetak tiket berdasarkan ID antrean yang baru dibuat
        return redirect()->route('antrian.cetak', $antrian->id);
    }

    // METHOD BARU: Menampilkan & mencetak tiket
    public function cetak($id)
    {
        $antrian = Antrian::with('layanan')->findOrFail($id);

        return view('kios.cetak', compact('antrian'));
    }
}