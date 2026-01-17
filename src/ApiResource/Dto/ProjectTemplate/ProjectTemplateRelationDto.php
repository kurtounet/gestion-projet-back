<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: ProjectTemplate::class)]
final class ProjectTemplateRelationDto
{
    #[Groups(['ProjectTemplate:relation:read'])]
    public int $id;
}
