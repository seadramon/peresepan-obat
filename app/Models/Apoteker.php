<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Apoteker extends Model
{
    use HasFactory;

    protected $table = 'apoteker';

    protected $fillable = [
        'nama', 'nohp', 'alamat', 'nomor_stra'
    ];

    public function account(): MorphOne
    {
        return $this->morphOne(User::class, 'account');
    }
}
