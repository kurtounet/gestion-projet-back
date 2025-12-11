<?php

namespace App\ApiResource\Dto\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour User.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'User',
    stateOptions: new Options(entityClass: User::class),
)]
#[Map(source: User::class)]
final class UserResponseDto
{
    #[Groups(['User:read'])]
    public int $id;

    #[Groups(['User:read'])]
    public string $firstName;

    #[Groups(['User:read'])]
    public string $lastName;

    #[Groups(['User:read'])]
    public string $email;

    #[Groups(['User:read'])]
    public array $roles;

    #[Groups(['User:read'])]
    public string $password;

    #[Groups(['User:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['User:read'])]
    public ?\DateTimeInterface $updatedAt;
}
