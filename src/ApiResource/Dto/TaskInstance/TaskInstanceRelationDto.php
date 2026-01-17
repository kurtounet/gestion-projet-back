<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: TaskInstance::class)]
final class TaskInstanceRelationDto
{
    #[Groups(['TaskInstance:relation:read'])]
    public int $id;
}
