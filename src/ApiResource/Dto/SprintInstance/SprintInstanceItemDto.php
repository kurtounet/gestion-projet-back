<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: SprintInstance::class)]
final class SprintInstanceItemDto
{
    #[Groups(['SprintInstance:item:read'])]
    public int $id;

    #[Groups(['SprintInstance:item:read'])]
    public string $name;

    #[Groups(['SprintInstance:item:read'])]
    public string $description;

    #[Groups(['SprintInstance:item:read'])]
    public string $icon;

    #[Groups(['SprintInstance:item:read'])]
    public string $color;

    #[Groups(['SprintInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['SprintInstance:item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:item:read'])]
    public ?int $position;

    #[Groups(['SprintInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $comment = null;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $sprintDependency = null;

    #[Groups(['SprintInstance:item:read'])]
    public ?string $projectInstance = null;
}
