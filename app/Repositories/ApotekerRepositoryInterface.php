<?php
namespace App\Repositories;

interface ApotekerRepositoryInterface
{
    public function getAllApoteker($limit, $search = null);
    public function getApoteker();
    public function getApotekerById($id);
    public function deleteApoteker($id);
    public function createApoteker(array $apotekerDetails, array $userDetails);
    public function updateApoteker($id, array $newDetails, array $userDetails);
}