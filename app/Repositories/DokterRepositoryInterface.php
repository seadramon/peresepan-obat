<?php
namespace App\Repositories;

interface DokterRepositoryInterface
{
    public function getAllDokter($limit, $search = null);
    public function getDokter();
    public function getDokterById($id);
    public function deleteDokter($id);
    public function createDokter(array $dokterDetails, array $userDetails);
    public function updateDOkter($id, array $dokterDetails, array $userDetails);
}