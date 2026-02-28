<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour ProjectTemplateSprintTemplate.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ProjectTemplateSprintTemplateUpdateDto
{
    #[Groups(['update'])]
    public ?int $sprintOrder = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $projectTemplate = null;
    #[Groups(['update'])]
    public ?string $sprintTemplate = null;
}
