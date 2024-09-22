<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Resep extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'resep';

    protected $fillable = [
        'hasil_pemeriksaan_id', 'obat_id', 'obat', 'harga_satuan', 'harga', 'jumlah'
    ];

    public function hasilPemeriksaan(): BelongsTo
    {
    	return $this->belongsTo(HasilPemeriksaan::class, 'hasil_pemeriksaan_id', 'id');
    }
}
