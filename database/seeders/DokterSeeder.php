<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use Hash;
use DB;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	try {
            DB::beginTransaction();

            $user = new User([
	        	'name' => 'dr.Tirta',
	        	'email' => 'tirta@gmail.com',
	        	'password' => Hash::make('dokter123')
	      	]);

			$dokter = new Dokter;
			
			$dokter->nama = 'dr.Tirta';
			$dokter->nohp = '08363636';
			$dokter->alamat = 'Jakarta';
			$dokter->spesialisasi = 'Umum';
			$dokter->nomor_izin_praktek = '82299229292';

			$dokter->save();
			
			$user = $dokter->account()->save($user);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            dd($e->getMessage());
        }
    }
}
