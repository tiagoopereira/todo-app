<?php 
namespace App\Controller;

use App\Repository\ToDoRepository;
use App\Service\ResponseService;
use App\Service\ToDoService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ToDoController extends AbstractController
{
    /** @var ToDoService */
    private $toDoService;

    /** @var ToDoRepository */
    private $toDoRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ToDoService $toDoService,
        ToDoRepository $toDoRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->toDoService = $toDoService;
        $this->toDoRepository = $toDoRepository;
        $this->entityManager = $entityManager;
    }

    public function create(Request $request): Response
    {
        try {
            $json = $request->getContent();
            $toDo = $this->toDoService->createEntity($json);

            $this->entityManager->persist($toDo);
            $this->entityManager->flush();

            $response = new ResponseService(true, $toDo, Response::HTTP_CREATED);

            return $response->getResponse();
        } catch (Exception $e) {
            $response = new ResponseService(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
            return $response->getResponse();
        }
    }

    public function getAll(): Response
    {
        $toDoList = $this->toDoRepository->findAll();

        $response = new ResponseService(true, $toDoList, Response::HTTP_OK);
        return $response->getResponse();
    }

    public function getOne(int $id): Response
    {
        $toDo = $this->toDoRepository->find($id);

        $response = new ResponseService(true, $toDo, Response::HTTP_OK);
        return $response->getResponse();
    }

    public function update(int $id, Request $request): Response
    {
        try {
            $json = $request->getContent();

            /** @var ToDo $newToDo */
            $newToDo = $this->toDoService->createEntity($json);
            $existingToDo = $this->toDoRepository->find($id);

            $existingToDo->setDescription($newToDo->getDescription());

            $this->entityManager->flush();

            $response = new ResponseService(true, $existingToDo, Response::HTTP_OK);
            return $response->getResponse();
        } catch (Exception $e) {
            $response = new ResponseService(false, $e->getMessage(), Response::HTTP_BAD_REQUEST);
            return $response->getResponse();
        }
    }

    public function delete(int $id): Response
    {
        $toDo = $this->toDoRepository->find($id);

        $this->entityManager->remove($toDo);
        $this->entityManager->flush();

        $response = new ResponseService(true, "", Response::HTTP_NO_CONTENT);
        return $response->getResponse();
    }
}