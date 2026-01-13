<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateCollectionItemDto
{
    #[Groups(['ProjectTemplateSprintTemplate:collection:read'])]
    public int $id;

    #[Groups(['ProjectTemplateSprintTemplate:collection:read'])]
    public int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
