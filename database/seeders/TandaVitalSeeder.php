<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TandaVitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tanda_vital')->insert([
        	['tanda' => 'Suhu badan'],
        	['tanda' => 'Tinggi Badan'],
        	['tanda' => 'Tekanan Darah'],
        	['tanda' => 'Suhu badan'],
        	['tanda' => 'Berat badan'],
        	['tanda' => 'heart rate'],
        	['tanda' => 'respiration rate']
        ]);
    }
}
