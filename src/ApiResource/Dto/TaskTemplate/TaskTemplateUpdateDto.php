<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour TaskTemplate.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class TaskTemplateUpdateDto
{
    #[Groups(['update'])]
    public ?string $name = null;

    #[Groups(['update'])]
    public ?string $description = null;

    #[Groups(['update'])]
    public ?int $parentTask = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $sprintTemplate = null;
    #[Groups(['update'])]
    public ?string $typeTask = null;
}
