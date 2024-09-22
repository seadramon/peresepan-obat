<?php
namespace App\Repositories;

interface PasienRepositoryInterface
{
    public function createPasien(array $pasienDetails);
    public function getPasien();
}