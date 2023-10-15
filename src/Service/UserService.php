<?php

namespace App\Service;

use App\Request\UserRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em)
    {
    }

    public function getUsers(): array
    {
        return $this->userRepository->findBy([], ['id' => 'ASC']);
    }

    public function getUser($id): User
    {
        return $this->userRepository->find($id);
    }

    public function createUser(UserRequest $userRequest): Response
    {
        if ($this->userRepository->duplicateEmail($userRequest->getEmail())) {
            return new Response("Email duplicate", 400);
        }

        $userRequest->validate();

        $user = (new User())
            ->setEmail($userRequest->getEmail())
            ->setName($userRequest->getName())
            ->setAge($userRequest->getAge())
            ->setSex($userRequest->getSex())
            ->setBirthday($userRequest->getBirthday())
            ->setPhone($userRequest->getPhone())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->em->persist($user);
        $this->em->flush();

        return new Response("User created successfully");
    }

    public function updateUser(int $id, UserRequest $userRequest): Response
    {
        $userRequest->validate();

        $user = $this->userRepository->getUserById($id);

        $user
            ->setEmail($userRequest->getEmail())
            ->setName($userRequest->getName())
            ->setAge($userRequest->getAge())
            ->setSex($userRequest->getSex())
            ->setBirthday($userRequest->getBirthday())
            ->setPhone($userRequest->getPhone())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->em->flush();

        return new Response("User update successfully");
    }

    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->getUserById($id);

        $this->em->remove($user);
        $this->em->flush();
    }
}
