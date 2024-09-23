<?php
namespace App\Repositories;

use App\Models\Pasien;
use DB;

class PasienRepository implements PasienRepositoryInterface
{

	public function getAllPasien($limit, $search = null)
    {
        if (!empty($search)) {
            $data = Pasien::where(DB::raw("LOWER(nama_pasien)"), 'like', '%'.strtolower($search).'%')->paginate($limit);
        } else {
           $data = Pasien::paginate($limit);
        }

        return $data;
    }

    public function getPasien()
    {
        return Pasien::get();
    }

    public function getPasienById($id)
    {
        return Pasien::findOrFail($id);
    }

    public function createPasien(array $pasienDetails)
    {
        return DB::transaction(function () use ($pasienDetails) {
            $data = Pasien::create($pasienDetails);
            
            return $data;
        });
    }

    public function updatePasien($id, array $newDetails)
    {
        return Pasien::whereId($id)->update($newDetails);
    }

}