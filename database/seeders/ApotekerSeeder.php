<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Apoteker;
use Hash;
use DB;

class ApotekerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $user = new User([
	        	'name' => 'Anggun',
	        	'email' => 'anggun@rsam.com',
	        	'password' => Hash::make('apoteker123')
	      	]);

			$apoteker = new Apoteker;
			
			$apoteker->nama = 'Anggun';
			$apoteker->nohp = '088999999';
			$apoteker->alamat = 'Sidoarjo';
			$apoteker->nomor_stra = '929292929';

			$apoteker->save();
			
			$user = $apoteker->account()->save($user);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            dd($e->getMessage());
        }
    }
}
