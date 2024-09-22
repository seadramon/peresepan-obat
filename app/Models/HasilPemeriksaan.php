<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilPemeriksaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'hasil_pemeriksaan';

    protected $fillable = [
        'dokter_id', 'apoteker_id', 'nama_pasien', 'nohp', 'alamat', 'tgl_pemeriksaan', 'hasil_pemeriksaan', 'tanda_vital', 'resep', 'berkas', 'status'
    ];

    public function dokter(): BelongsTo
    {
    	return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }

    public function resepApoteker(): HasMany
    {
    	return $this->HasMany(Resep::class, 'hasil_pemeriksaan_id', 'id');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }
}
