<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: SprintTask::class)]
final class SprintTaskItemDto
{
    #[Groups(['SprintTask:item:read'])]
    public int $id;

    #[Groups(['SprintTask:item:read'])]
    public int $taskOrder;

    #[Groups(['SprintTask:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintTask:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['SprintTask:item:read'])]
    public ?string $taskTemplate = null;
}
