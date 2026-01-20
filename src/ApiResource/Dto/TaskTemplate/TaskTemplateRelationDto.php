<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: TaskTemplate::class)]
final class TaskTemplateRelationDto
{
    #[Groups(['TaskTemplate:relation:read'])]
    public int $id;
}
