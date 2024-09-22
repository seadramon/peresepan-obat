<?php
namespace App\Repositories;

use App\Models\Pasien;
use DB;

class PasienRepository implements PasienRepositoryInterface
{

    public function createPasien(array $pasienDetails)
    {
        return DB::transaction(function () use ($pasienDetails) {
            $data = Pasien::create($pasienDetails);
            
            return $data;
        });
    }

    public function getPasien()
    {
        return Pasien::get();
    }
}