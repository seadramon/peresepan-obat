<?php
namespace App\Repositories;

use App\Models\Resep;
use DB;

class ResepRepository implements ResepRepositoryInterface
{

    public function getAllResepByPemeriksaan($pemeriksaanId)
    {
        $data = Resep::where('hasil_pemeriksaan_id', $pemeriksaanId)->get();

        return $data;
    }

    public function getResepById($id)
    {
        return Resep::findOrFail($id);
    }

    public function deleteResepByPemeriksaan($pemeriksaanId)
    {
        Resep::where('hasil_pemeriksaan_id', $pemeriksaanId)->delete();
    }

    public function createMassResep(array $resepDetails)
    {
        return DB::transaction(function () use ($resepDetails) {
            foreach ($resepDetails as $resepDetail) {
                Resep::create($resepDetail);
            }
            
            return true;
        });
    }
}