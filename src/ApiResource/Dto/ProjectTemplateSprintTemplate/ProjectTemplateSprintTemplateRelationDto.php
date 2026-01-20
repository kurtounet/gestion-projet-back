<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateRelationDto
{
    #[Groups(['ProjectTemplateSprintTemplate:relation:read'])]
    public int $id;
}
