<?php
namespace App\Service;

use App\Entity\ToDo;
use App\Service\EntityServiceInterface;
use Exception;

class ToDoService implements EntityServiceInterface
{
    public function createEntity(string $json): object
    {
        $data = json_decode($json);

        if (!isset($data->description)) {
            throw new Exception("Description is required!");
        }

        $toDo = new ToDo();
        $toDo->setDescription($data->description);

        return $toDo;
    }
}