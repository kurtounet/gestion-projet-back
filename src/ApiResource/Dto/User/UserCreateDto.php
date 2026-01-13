<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour User.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: User::class)]
final class UserCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public string $firstName;

    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public string $lastName;

    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public string $email;

    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public array $roles;

    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public string $password;

    #[Assert\NotBlank]
    #[Groups(['User:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['User:create'])]
    public ?\DateTimeInterface $updatedAt;


}
