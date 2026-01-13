<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour TaskInstance.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TaskInstance::class)]
final class TaskInstanceUpdateDto
{
    #[Groups(['TaskInstance:update'])]
    public ?string $name;

    #[Groups(['TaskInstance:update'])]
    public ?string $description;

    #[Groups(['TaskInstance:update'])]
    public ?\DateTimeInterface $startDate;

    #[Groups(['TaskInstance:update'])]
    public ?\DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:update'])]
    public ?int $position;

    #[Groups(['TaskInstance:update'])]
    public ?string $icon;

    #[Groups(['TaskInstance:update'])]
    public ?string $color;

    #[Groups(['TaskInstance:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:update'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:update'])]
    public ?string $updatedByUser;

    #[Groups(['TaskInstance:update'])]
    public ?string $user;
    #[Groups(['TaskInstance:update'])]
    public ?string $taskTemplate;
    #[Groups(['TaskInstance:update'])]
    public ?string $sprintInstance;
    #[Groups(['TaskInstance:update'])]
    public ?string $priority;
    #[Groups(['TaskInstance:update'])]
    public ?string $status;
    #[Groups(['TaskInstance:update'])]
    public ?string $typeTask;
    #[Groups(['TaskInstance:update'])]
    public ?string $parentTask;
    #[Groups(['TaskInstance:update'])]
    public ?string $dependency;
    #[Groups(['TaskInstance:update'])]
    public ?string $comment;
}
