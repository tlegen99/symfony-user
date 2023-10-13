<?php

namespace App\Service;

use App\DTO\UserRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em)
    {
    }

    public function getUsers(): array
    {
        return $this->userRepository->findBy([], ['id' => 'ASC']);
    }

    public function createUser(Request $request): int
    {
        $json = $request->getContent();
        $data = json_decode($json);
        $dto_user = new UserRequest($data);

        if ($this->userRepository->duplicateEmail($dto_user->getEmail())) {
            throw new \RuntimeException('User duplicate');
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

        return $user->getId();
    }
}
