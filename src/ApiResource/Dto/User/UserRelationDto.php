<?php

namespace App\ApiResource\Dto\User;

use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: User::class)]
final class UserRelationDto
{
    #[Groups(['User:relation:read'])]
    public int $id;
}
