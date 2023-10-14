<?php

namespace App\Service;

use App\DTO\UserRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em, private readonly ValidatorInterface $validator)
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

    public function createUser(Request $request): Response
    {
        $json     = $request->getContent();
        $dto_user = new UserRequest(json_decode($json));

        if ($this->userRepository->duplicateEmail($dto_user->getEmail())) {
            return new Response("Email duplicate", 400);
        }

        $errors = $this->validator->validate($dto_user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString, 400);
        }

        $user = (new User())
            ->setEmail($dto_user->getEmail())
            ->setName($dto_user->getName())
            ->setAge($dto_user->getAge())
            ->setSex($dto_user->getSex())
            ->setBirthday($dto_user->getBirthday())
            ->setPhone($dto_user->getPhone());

        $this->em->persist($user);
        $this->em->flush();

        return new Response("User created successfully");
    }

    public function updateUser(int $id, Request $request): Response
    {
        $user     = $this->userRepository->getUserById($id);
        $json     = $request->getContent();
        $dto_user = new UserRequest(json_decode($json));

        if ($this->userRepository->duplicateEmail($dto_user->getEmail())) {
            return new Response("Email duplicate", 400);
        }

        $errors = $this->validator->validate($dto_user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString, 400);
        }

        $user
            ->setEmail($dto_user->getEmail())
            ->setName($dto_user->getName())
            ->setAge($dto_user->getAge())
            ->setSex($dto_user->getSex())
            ->setBirthday($dto_user->getBirthday())
            ->setPhone($dto_user->getPhone());

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
