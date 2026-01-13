<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Technology::class)]
final class TechnologyRelationDto
{
    #[Groups(['Technology:relation:read'])]
    public int $id;
}
