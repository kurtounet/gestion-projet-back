<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Priority::class)]
final class PriorityRelationDto
{
    #[Groups(['Priority:relation:read'])]
    public int $id;
}
