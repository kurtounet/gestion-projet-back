<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour TaskInstance.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class TaskInstanceUpdateDto
{
    #[Groups(['update'])]
    public ?string $name = null;

    #[Groups(['update'])]
    public ?string $description = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $dueDate = null;

    #[Groups(['update'])]
    public ?int $position = null;

    #[Groups(['update'])]
    public ?string $icon = null;

    #[Groups(['update'])]
    public ?string $color = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $createdByUser = null;

    #[Groups(['update'])]
    public ?string $updatedByUser = null;

    #[Groups(['update'])]
    public ?string $user = null;
    #[Groups(['update'])]
    public ?string $taskTemplate = null;
    #[Groups(['update'])]
    public ?string $sprintInstance = null;
    #[Groups(['update'])]
    public ?string $priority = null;
    #[Groups(['update'])]
    public ?string $status = null;
    #[Groups(['update'])]
    public ?string $typeTask = null;
    #[Groups(['update'])]
    public ?string $parentTask = null;
    #[Groups(['update'])]
    public ?string $dependency = null;
    #[Groups(['update'])]
    public ?string $comment = null;
}
