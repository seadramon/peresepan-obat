<?php
namespace App\Repositories;

interface PasienRepositoryInterface
{
    public function getAllPasien($limit, $search = null);
    public function getPasien();
    public function getPasienById($id);
    public function createPasien(array $pasienDetails);
    public function updatePasien($id, array $newDetails);
}