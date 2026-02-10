<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintTask.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
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

    #[Groups(['SprintTask:create'])]
    public ?string $sprintTemplate;
    #[Groups(['SprintTask:create'])]
    public ?string $taskTemplate;
}
