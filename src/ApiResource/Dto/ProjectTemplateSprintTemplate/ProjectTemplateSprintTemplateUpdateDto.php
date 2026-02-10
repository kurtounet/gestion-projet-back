<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour ProjectTemplateSprintTemplate.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateUpdateDto
{
    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?string $projectTemplate;
    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?string $sprintTemplate;
}
