<?php
namespace App\Repositories;

use App\Models\Dokter;
use App\Models\User;
use DB;
use Hash;

class DokterRepository implements DokterRepositoryInterface
{
    public function getAllDokter($limit, $search = null)
    {
        if (!empty($search)) {
            $data = Dokter::where(DB::raw("LOWER(nama)"), 'like', '%'.strtolower($search).'%')->paginate($limit);
        } else {
           $data = Dokter::paginate($limit);
        }

        return $data;
    }

    public function getDokter()
    {
        return Dokter::get();
    }

    public function getDokterById($id)
    {
        return Dokter::findOrFail($id);
    }

    public function deleteDokter($id)
    {
        Dokter::destroy($id);
    }

    public function createDokter(array $dokterDetails, array $userDetails)
    {
        return DB::transaction(function () use ($dokterDetails, $userDetails) {
            $user = new User($userDetails);

            $dokter = new Dokter;
            
            $dokter->nama = $dokterDetails['nama'];
            $dokter->nohp = $dokterDetails['nohp'];
            $dokter->alamat = $dokterDetails['alamat'];
            $dokter->spesialisasi = $dokterDetails['spesialisasi'];
            $dokter->nomor_izin_praktek = $dokterDetails['nomor_izin_praktek'];

            $dokter->save();

            $user = $dokter->account()->save($user);
            
            return $dokter;
        });
    }

    public function updateDokter($id, array $dokterDetails, array $userDetails)
    {
        return DB::transaction(function () use ($id, $dokterDetails, $userDetails) {
            $dokter = Dokter::find($id);
            
            $dokter->nama = $dokterDetails['nama'];
            $dokter->nohp = $dokterDetails['nohp'];
            $dokter->alamat = $dokterDetails['alamat'];
            $dokter->spesialisasi = $dokterDetails['spesialisasi'];
            $dokter->nomor_izin_praktek = $dokterDetails['nomor_izin_praktek'];

            $dokter->save();

            $dokter->account->password = $userDetails['password'];
            $dokter->account->save();

            return $dokter;
        });
    }
}