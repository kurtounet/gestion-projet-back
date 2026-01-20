<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: SprintInstance::class)]
final class SprintInstanceRelationDto
{
    #[Groups(['SprintInstance:relation:read'])]
    public int $id;
}
