<?php

namespace App\Services;

use App\Models\Antrian;
use App\Models\Layanan;
use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AntrianService
{
    /**
     * Membuat data pengunjung dan nomor antrean baru secara atomik.
     */
    public function createAntrian(array $pengunjungData, int $layananId): Antrian
    {
        return DB::transaction(function () use ($pengunjungData, $layananId) {
            // 1. Simpan Data Pengunjung
            $pengunjung = Pengunjung::create($pengunjungData);
            $layanan = Layanan::findOrFail($layananId);
            $today = Carbon::today()->toDateString();

            // 2. Hitung jumlah antrean layanan tersebut hari ini (dengan Lock For Update)
            $lastAntrian = Antrian::where('layanan_id', $layananId)
                ->where('tanggal', $today)
                ->lockForUpdate()
                ->count();

            // 3. Formating nomor antrean, contoh: A + 001 = A001
            $nextSequence = $lastAntrian + 1;
            $nomorAntrian = $layanan->kode_layanan . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

            // 4. Simpan Antrean
            return Antrian::create([
                'nomor_antrian' => $nomorAntrian,
                'pengunjung_id' => $pengunjung->id,
                'layanan_id'    => $layananId,
                'tanggal'       => $today,
                'status'        => 'Menunggu',
            ]);
        });
    }
}