<?php
namespace App\Repositories;

interface ResepRepositoryInterface
{
    public function getAllResepByPemeriksaan($pemeriksaanId);
    public function getResepById($id);
    public function deleteResepByPemeriksaan($pemeriksaanId);
    public function createMassResep(array $resepDetails);
}