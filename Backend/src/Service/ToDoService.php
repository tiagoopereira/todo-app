<?php
namespace App\Service;

use App\Entity\ToDo;
use App\Service\EntityServiceInterface;

class ToDoService implements EntityServiceInterface
{
    public function createEntity(string $json): object
    {
        $data = json_decode($json);
        $toDo = new ToDo();
        $toDo->setDescription($data->description);

        return $toDo;
    }
}