<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateItemDto
{
    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public int $id;

    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectTemplateSprintTemplate:item:read'])]
    public ?string $sprintTemplate = null;
}
