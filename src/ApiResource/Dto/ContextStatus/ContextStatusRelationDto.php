<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: ContextStatus::class)]
final class ContextStatusRelationDto
{
    #[Groups(['ContextStatus:relation:read'])]
    public int $id;
}
