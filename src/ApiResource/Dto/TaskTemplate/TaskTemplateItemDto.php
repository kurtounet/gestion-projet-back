<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: TaskTemplate::class)]
final class TaskTemplateItemDto
{
    #[Groups(['TaskTemplate:item:read'])]
    public int $id;

    #[Groups(['TaskTemplate:item:read'])]
    public string $name;

    #[Groups(['TaskTemplate:item:read'])]
    public string $description;

    #[Groups(['TaskTemplate:item:read'])]
    public int $parentTask;

    #[Groups(['TaskTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskTemplate:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['TaskTemplate:item:read'])]
    public ?string $typeTask = null;
}
