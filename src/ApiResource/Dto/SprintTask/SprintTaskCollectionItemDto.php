<?php

namespace App\ApiResource\Dto\SprintTask;

use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: SprintTask::class)]
final class SprintTaskCollectionItemDto
{
    #[Groups(['SprintTask:collection:read'])]
    public int $id;

    #[Groups(['SprintTask:collection:read'])]
    public int $taskOrder;

    #[Groups(['SprintTask:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
