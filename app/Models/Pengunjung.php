<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengunjung extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'instansi', 'no_hp'];

    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }
}