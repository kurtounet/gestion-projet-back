<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour SprintTask.
 * Utilisé typiquement pour PATCH/PUT.
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
}
