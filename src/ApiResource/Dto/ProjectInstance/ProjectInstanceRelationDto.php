<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: ProjectInstance::class)]
final class ProjectInstanceRelationDto
{
    #[Groups(['ProjectInstance:relation:read'])]
    public int $id;
}
