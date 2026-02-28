<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour User.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class UserUpdateDto
{
    #[Groups(['update'])]
    public ?string $firstName = null;

    #[Groups(['update'])]
    public ?string $lastName = null;

    #[Groups(['update'])]
    public ?string $email = null;

    #[Groups(['update'])]
    public ?array $roles = null;

    #[Groups(['update'])]
    public ?string $password = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;
}
