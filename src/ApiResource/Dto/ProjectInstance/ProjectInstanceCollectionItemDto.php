<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: ProjectInstance::class)]
final class ProjectInstanceCollectionItemDto
{
    #[Groups(['ProjectInstance:collection:read'])]
    public int $id;

    #[Groups(['ProjectInstance:collection:read'])]
    public string $name;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $description;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $color;

    #[Groups(['ProjectInstance:collection:read'])]
    public bool $isFavory;

    #[Groups(['ProjectInstance:collection:read'])]
    public int $position;

    #[Groups(['ProjectInstance:collection:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['ProjectInstance:collection:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?string $updatedByUser;

    #[Groups(['ProjectInstance:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
