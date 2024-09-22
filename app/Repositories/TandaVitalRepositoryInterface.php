<?php
namespace App\Repositories;

interface TandaVitalRepositoryInterface
{
    public function getAllTandaVital($limit, $search = null);
    public function getTandaVital();
    public function getTandaVitalById($id);
    public function deleteTandaVital($id);
    public function createTandaVital(array $tandaVitalDetails);
    public function updateTandaVital($id, array $newDetails);
}