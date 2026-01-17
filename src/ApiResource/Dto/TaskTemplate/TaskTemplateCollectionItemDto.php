<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: TaskTemplate::class)]
final class TaskTemplateCollectionItemDto
{
    #[Groups(['TaskTemplate:collection:read'])]
    public int $id;

    #[Groups(['TaskTemplate:collection:read'])]
    public string $name;

    #[Groups(['TaskTemplate:collection:read'])]
    public string $description;

    #[Groups(['TaskTemplate:collection:read'])]
    public int $parentTask;

    #[Groups(['TaskTemplate:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
