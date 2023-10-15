<?php

namespace App\Request;

use App\Helpers\HelperFunctions;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    protected string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    protected string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(5)]
    protected int $age;

    #[Assert\NotBlank]
    #[Assert\Range(min: 1, max: 2)]
    protected int $sex;

    #[Assert\NotBlank]
    protected string $birthday;

    #[Assert\NotBlank]
    protected string $phone;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return htmlspecialchars($this->name);
    }

    public function getAge(): int
    {
        return $this->age;
    }

    private static function getTwoSex(): array
    {
        return [
            1 => 'Мужской',
            2 => 'Женский',
        ];
    }

    public function getSex(): string
    {
        return static::getTwoSex()[$this->sex];
    }

    public function getBirthday(): string
    {
        $birthday = new \DateTimeImmutable($this->birthday);
        return HelperFunctions::rus_date($birthday);
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
