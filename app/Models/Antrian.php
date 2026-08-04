<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_antrian',
        'pengunjung_id',
        'layanan_id',
        'user_id',
        'tanggal',
        'status',
        'waktu_panggil',
        'waktu_selesai'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_panggil' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengunjung::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}