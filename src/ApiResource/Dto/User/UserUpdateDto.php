<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour User.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
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
