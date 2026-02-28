<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour SprintTask.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class SprintTaskUpdateDto
{
    #[Groups(['update'])]
    public ?int $taskOrder = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $sprintTemplate = null;
    #[Groups(['update'])]
    public ?string $taskTemplate = null;
}
