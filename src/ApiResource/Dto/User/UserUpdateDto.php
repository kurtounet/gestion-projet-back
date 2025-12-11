<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour User.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: User::class)]
final class UserUpdateDto
{
    #[Groups(['User:update'])]
    public ?string $firstName;

    #[Groups(['User:update'])]
    public ?string $lastName;

    #[Groups(['User:update'])]
    public ?string $email;

    #[Groups(['User:update'])]
    public ?array $roles;

    #[Groups(['User:update'])]
    public ?string $password;

    #[Groups(['User:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['User:update'])]
    public ?\DateTimeInterface $updatedAt;
}
