<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/api/v1/users', name: 'get_users', methods: ['GET'])]
    public function showUsers(): Response
    {
        return $this->json($this->userService->getUsers());
    }

    #[Route('/api/v1/user/{id}', name: 'get_user', methods: ['GET'])]
    public function showUser(int $id): Response
    {
        return $this->json($this->userService->getUser($id));
    }

    #[Route('/api/v1/user', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        return $this->json($this->userService->createUser($request));
    }

    #[Route('/api/v1/user/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(int $id, Request $request): Response
    {
        return $this->json($this->userService->updateUser($id, $request));
    }

    #[Route('/api/v1/user/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {
        $this->userService->deleteUser($id);

        return $this->json('User deleted');
    }
}
