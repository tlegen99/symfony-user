<?php

namespace App\DTO;

class UserRequest
{
    private string $email;
    private string $name;
    private int $age;
    private string $sex;
    private string $birthday;
    private string $phone;

    public function __construct(object $data)
    {
        $this->email = $data->email;
        $this->name = $data->name;
        $this->age = $data->age;
        $this->sex = $data->sex;
        $this->birthday = $data->birthday;
        $this->phone = $data->phone;
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

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
