<?php
namespace App\Repositories;

use App\Models\Apoteker;
use App\Models\User;
use DB;

class ApotekerRepository implements ApotekerRepositoryInterface
{
    public function getAllApoteker($limit, $search = null)
    {
        if (!empty($search)) {
            $data = Apoteker::where(DB::raw("LOWER(nama)"), 'like', '%'.strtolower($search).'%')->paginate($limit);
        } else {
           $data = Apoteker::paginate($limit);
        }

        return $data;
    }

    public function getApoteker()
    {
        return Apoteker::get();
    }

    public function getApotekerById($id)
    {
        return Apoteker::findOrFail($id);
    }

    public function deleteApoteker($id)
    {
        Apoteker::destroy($id);
    }

    public function createApoteker(array $apotekerDetails, array $userDetails)
    {
        return DB::transaction(function () use ($apotekerDetails, $userDetails) {
            $user = new User($userDetails);

            $apoteker = new Apoteker;
            
            $apoteker->nama = $apotekerDetails['nama'];
            $apoteker->nohp = $apotekerDetails['nohp'];
            $apoteker->alamat = $apotekerDetails['alamat'];
            $apoteker->nomor_stra = $apotekerDetails['nomor_stra'];

            $apoteker->save();

            $user = $apoteker->account()->save($user);
            
            return $apoteker;
        });
    }

    public function updateApoteker($id, array $apotekerDetails, array $userDetails)
    {
        return DB::transaction(function () use ($id, $apotekerDetails, $userDetails) {
            $apoteker = Apoteker::find($id);
            
            $apoteker->nama = $apotekerDetails['nama'];
            $apoteker->nohp = $apotekerDetails['nohp'];
            $apoteker->alamat = $apotekerDetails['alamat'];
            $apoteker->nomor_stra = $apotekerDetails['nomor_stra'];

            $apoteker->save();

            $apoteker->account->password = $userDetails['password'];
            $apoteker->account->save();

            return $apoteker;
        });
    }
}