<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: SprintInstance::class)]
final class SprintInstanceCollectionItemDto
{
    #[Groups(['SprintInstance:collection:read'])]
    public int $id;

    #[Groups(['SprintInstance:collection:read'])]
    public string $name;

    #[Groups(['SprintInstance:collection:read'])]
    public string $description;

    #[Groups(['SprintInstance:collection:read'])]
    public string $icon;

    #[Groups(['SprintInstance:collection:read'])]
    public string $color;

    #[Groups(['SprintInstance:collection:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['SprintInstance:collection:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:collection:read'])]
    public ?int $position;

    #[Groups(['SprintInstance:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:collection:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:collection:read'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:collection:read'])]
    public ?string $updatedByUser;
}
