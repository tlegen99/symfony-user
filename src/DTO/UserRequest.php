<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(5)]
    private int $age;

    #[Assert\NotBlank]
    private string $sex;

    #[Assert\NotBlank]
    private \DateTimeInterface $birthday;

    #[Assert\NotBlank]
    private string $phone;

    public function __construct(object $data)
    {
        $this->email = trim($data->email);
        $this->name = trim($data->name);
        $this->age = trim($data->age);
        $this->sex = trim($data->sex);
        $this->birthday = new \DateTimeImmutable(trim($data->birthday));
        $this->phone = trim($data->phone);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function getBirthday(): \DateTimeInterface
    {
        return $this->birthday;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
