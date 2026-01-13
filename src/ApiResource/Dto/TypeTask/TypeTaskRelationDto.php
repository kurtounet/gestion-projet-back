<?php

namespace App\ApiResource\Dto\TypeTask;

use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: TypeTask::class)]
final class TypeTaskRelationDto
{
    #[Groups(['TypeTask:relation:read'])]
    public int $id;
}
