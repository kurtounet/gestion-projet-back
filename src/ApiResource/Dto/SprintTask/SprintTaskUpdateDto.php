<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour SprintTask.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: SprintTask::class)]
final class SprintTaskUpdateDto
{
    #[Groups(['SprintTask:update'])]
    public ?int $taskOrder;

    #[Groups(['SprintTask:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['SprintTask:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintTask:update'])]
    public ?string $sprintTemplate;
    #[Groups(['SprintTask:update'])]
    public ?string $taskTemplate;
}
