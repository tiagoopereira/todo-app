<?php
namespace App\Service;

interface EntityServiceInterface
{
    public function createEntity(string $json): object;
}