<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: TaskInstance::class)]
final class TaskInstanceCollectionItemDto
{
    #[Groups(['TaskInstance:collection:read'])]
    public int $id;

    #[Groups(['TaskInstance:collection:read'])]
    public string $name;

    #[Groups(['TaskInstance:collection:read'])]
    public string $description;

    #[Groups(['TaskInstance:collection:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['TaskInstance:collection:read'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:collection:read'])]
    public ?int $position;

    #[Groups(['TaskInstance:collection:read'])]
    public string $icon;

    #[Groups(['TaskInstance:collection:read'])]
    public string $color;

    #[Groups(['TaskInstance:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:collection:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:collection:read'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:collection:read'])]
    public ?string $updatedByUser;
}
