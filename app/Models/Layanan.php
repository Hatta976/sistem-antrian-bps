<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = ['kode_layanan', 'nama_layanan', 'status'];

    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }
}