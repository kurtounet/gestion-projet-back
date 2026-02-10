<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour TaskTemplate.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TaskTemplate::class)]
final class TaskTemplateUpdateDto
{
    #[Groups(['TaskTemplate:update'])]
    public ?string $name;

    #[Groups(['TaskTemplate:update'])]
    public ?string $description;

    #[Groups(['TaskTemplate:update'])]
    public ?int $parentTask;

    #[Groups(['TaskTemplate:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskTemplate:update'])]
    public ?string $sprintTemplate;
    #[Groups(['TaskTemplate:update'])]
    public ?string $typeTask;
}
