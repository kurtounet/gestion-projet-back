<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: SprintTemplate::class)]
final class SprintTemplateRelationDto
{
    #[Groups(['SprintTemplate:relation:read'])]
    public int $id;
}
