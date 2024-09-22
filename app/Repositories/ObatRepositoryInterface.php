<?php
namespace App\Repositories;

interface ObatRepositoryInterface
{
    public function authenticate();
    public function getListObat($token);
    public function getHargaObat($token, $uuid);
}