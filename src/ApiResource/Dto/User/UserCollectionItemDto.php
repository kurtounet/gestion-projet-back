<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: User::class)]
final class UserCollectionItemDto
{
    #[Groups(['User:collection:read'])]
    public int $id;

    #[Groups(['User:collection:read'])]
    public string $firstName;

    #[Groups(['User:collection:read'])]
    public string $lastName;

    #[Groups(['User:collection:read'])]
    public string $email;

    #[Groups(['User:collection:read'])]
    public array $roles;

    #[Groups(['User:collection:read'])]
    public string $password;

    #[Groups(['User:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['User:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
