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
    public function users(): Response
    {
        return $this->json($this->userService->getUsers());
    }

    #[Route('/api/v1/user', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        return $this->json($this->userService->createUser($request));
    }
}
