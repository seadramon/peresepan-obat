<?php
namespace App\Repositories;

interface HasilPemeriksaanRepositoryInterface
{
    public function getAllHasilPemeriksaan($limit, $search = null);
    public function getHasilPemeriksaanDokter($limit, $search = null);
    public function getHasilPemeriksaanById($id);
    public function deleteHasilPemeriksaan($id);
    public function createHasilPemeriksaan(array $hasilPemeriksaanDetails);
    public function updateHasilPemeriksaan($id, array $newDetails);
}