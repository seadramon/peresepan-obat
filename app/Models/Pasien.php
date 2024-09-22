<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pasien extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pasien';

    protected $fillable = [
        'nama_pasien', 'nohp', 'alamat'
    ];
}
