<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // 1. Menampilkan Dashboard Petugas
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $layanans = Layanan::all();

        // Antrean hari ini yang 'Menunggu'
        $antrianMenunggu = Antrian::with('layanan')
            ->where('tanggal', $today)
            ->where('status', 'Menunggu')
            ->orderBy('id', 'asc')
            ->get();

        // Antrean terakhir yang 'Dipanggil'
        $antrianDipanggil = Antrian::with('layanan')
            ->where('tanggal', $today)
            ->where('status', 'Dipanggil')
            ->orderBy('updated_at', 'desc')
            ->first();

        // Antrean yang 'Selesai'
        $antrianSelesai = Antrian::with('layanan')
            ->where('tanggal', $today)
            ->where('status', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('petugas.index', compact('layanans', 'antrianMenunggu', 'antrianDipanggil', 'antrianSelesai'));
    }

    // 2. Memproses Pemanggilan Antrean (Support AJAX & Form Biasa)
    public function panggil(Request $request)
    {
        $request->validate([
            'loket' => 'required|string',
            'layanan_id' => 'nullable|exists:layanans,id'
        ]);

        $today = Carbon::today()->toDateString();

        $query = Antrian::where('tanggal', $today)->where('status', 'Menunggu');

        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $antrianBerikutnya = $query->orderBy('id', 'asc')->first();

        if (!$antrianBerikutnya) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada antrean yang sedang menunggu!'
                ], 400);
            }

            return back()->with('error', 'Tidak ada antrean yang sedang menunggu!');
        }

        // Update status antrean menjadi Dipanggil
        $antrianBerikutnya->update([
            'status' => 'Dipanggil',
            'loket' => $request->loket,
            'updated_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memanggil nomor ' . $antrianBerikutnya->nomor_antrian,
                'antrian' => [
                    'nomor_antrian' => $antrianBerikutnya->nomor_antrian,
                    'loket' => $request->loket,
                ]
            ]);
        }

        return back()->with('success', 'Berhasil memanggil nomor ' . $antrianBerikutnya->nomor_antrian);
    }

    // 3. Selesaikan Antrean (Method Sesuai Nama Route)
    public function selesaikanAntrian($id)
    {
        $antrian = Antrian::findOrFail($id);

        $antrian->update([
            'status' => 'Selesai',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Antrean ' . $antrian->nomor_antrian . ' berhasil diselesaikan.');
    }

    // 4. Alias Method Selesai (Agar Tetap Kompatibel Jika Ada Route Lain yang Memanggil `selesai`)
    public function selesai($id)
    {
        return $this->selesaikanAntrian($id);
    }
}