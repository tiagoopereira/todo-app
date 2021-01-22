<?php 
namespace App\Controller;

use App\Repository\ToDoRepository;
use App\Service\ToDoService;
use Doctrine\ORM\EntityManagerInterface;
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
        $json = $request->getContent();
        $toDo = $this->toDoService->createEntity($json);

        $this->entityManager->persist($toDo);
        $this->entityManager->flush();

        return new JsonResponse($toDo, Response::HTTP_CREATED);
    }

    public function getAll(): Response
    {
        $toDoList = $this->toDoRepository->findAll();

        return new JsonResponse($toDoList, Response::HTTP_OK);
    }

    public function getOne(int $id): Response
    {
        $toDo = $this->toDoRepository->find($id);

        return new JsonResponse($toDo, Response::HTTP_OK);
    }

    public function update(int $id, Request $request): Response
    {
        $json = $request->getContent();

        /** @var ToDo $newToDo */
        $newToDo = $this->toDoService->createEntity($json);
        $existingToDo = $this->toDoRepository->find($id);

        $existingToDo->setDescription($newToDo->getDescription());

        $this->entityManager->flush();

        return new JsonResponse($existingToDo, Response::HTTP_OK);
    }

    public function delete(int $id): Response
    {
        $toDo = $this->toDoRepository->find($id);

        $this->entityManager->remove($toDo);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}