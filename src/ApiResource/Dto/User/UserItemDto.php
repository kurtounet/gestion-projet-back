<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: User::class)]
final class UserItemDto
{
    #[Groups(['User:item:read'])]
    public int $id;

    #[Groups(['User:item:read'])]
    public string $firstName;

    #[Groups(['User:item:read'])]
    public string $lastName;

    #[Groups(['User:item:read'])]
    public string $email;

    #[Groups(['User:item:read'])]
    public array $roles;

    #[Groups(['User:item:read'])]
    public string $password;

    #[Groups(['User:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['User:item:read'])]
    public ?\DateTimeInterface $updatedAt;
}
