<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: SprintTask::class)]
final class SprintTaskRelationDto
{
    #[Groups(['SprintTask:relation:read'])]
    public int $id;
}
