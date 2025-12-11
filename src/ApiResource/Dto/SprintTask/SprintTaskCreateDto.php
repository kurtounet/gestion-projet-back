<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintTask.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: SprintTask::class)]
final class SprintTaskCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['SprintTask:create'])]
    public int $taskOrder;

    #[Assert\NotBlank]
    #[Groups(['SprintTask:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:create'])]
    public ?\DateTimeInterface $updatedAt;
}
