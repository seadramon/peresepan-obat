<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'nama', 'nohp', 'alamat', 'spesialisasi', 'nomor_izin_praktek'
    ];

    public function account(): MorphOne
    {
        return $this->morphOne(User::class, 'account');
    }
}
