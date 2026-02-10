<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: TaskInstance::class)]
final class TaskInstanceItemDto
{
    #[Groups(['TaskInstance:item:read'])]
    public int $id;

    #[Groups(['TaskInstance:item:read'])]
    public string $name;

    #[Groups(['TaskInstance:item:read'])]
    public string $description;

    #[Groups(['TaskInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['TaskInstance:item:read'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:item:read'])]
    public ?int $position;

    #[Groups(['TaskInstance:item:read'])]
    public string $icon;

    #[Groups(['TaskInstance:item:read'])]
    public string $color;

    #[Groups(['TaskInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $user = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $taskTemplate = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $sprintInstance = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $typeTask = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $parentTask = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $dependency = null;

    #[Groups(['TaskInstance:item:read'])]
    public ?string $comment = null;
}
