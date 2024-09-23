<?php
namespace App\Repositories;

use App\Models\HasilPemeriksaan;
use DB;

class HasilPemeriksaanRepository implements HasilPemeriksaanRepositoryInterface
{

    public function getAllHasilPemeriksaan($limit, $search = null)
    {
        if (!empty($search)) {
            $data = HasilPemeriksaan::whereHas('pasien', function ($query) use($search){
                    $query->where(DB::raw("LOWER(nama_pasien)"), 'like', '%'.strtolower($search).'%');
                })
                ->orderBy('created_at', 'asc')
                ->paginate($limit);
        } else {
            $data = HasilPemeriksaan::orderBy('created_at', 'asc')
                ->paginate($limit);
        }

        return $data;
    }

    public function getHasilPemeriksaanDokter($limit, $search = null)
    {
        $dokterId = \Auth::user()->account->id;

        if (!empty($search)) {
            $data = HasilPemeriksaan::where('dokter_id', $dokterId)
                ->whereHas('pasien', function ($query) use($search){
                    $query->where(DB::raw("LOWER(nama_pasien)"), 'like', '%'.strtolower($search).'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
        } else {
            $data = HasilPemeriksaan::where('dokter_id', $dokterId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit);
        }

        return $data;
    }

    public function getHasilPemeriksaanById($id)
    {
        return HasilPemeriksaan::findOrFail($id);
    }

    public function deleteHasilPemeriksaan($id)
    {
        HasilPemeriksaan::destroy($id);
    }

    public function createHasilPemeriksaan(array $hasilPemeriksaanDetails)
    {
        return DB::transaction(function () use ($hasilPemeriksaanDetails) {
            $data = HasilPemeriksaan::create($hasilPemeriksaanDetails);
            
            return $data;
        });
    }

    public function updateHasilPemeriksaan($id, array $newDetails)
    {
        return HasilPemeriksaan::whereId($id)->update($newDetails);
    }
}