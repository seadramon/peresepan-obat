<?php
namespace App\Repositories;

interface LogRepositoryInterface
{
    public function getAllLog($limit, $search = null);
    public function createLog(array $logDetails);
}