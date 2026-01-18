<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ProjectInstance::class)]
final class ProjectInstanceItemDto
{
    #[Groups(['ProjectInstance:item:read'])]
    public int $id;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $name = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $pathProject = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $description = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $icon = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $color = null;

    #[Groups(['ProjectInstance:item:read'])]
    public bool $isFavory;

    #[Groups(['ProjectInstance:item:read'])]
    public ?int $position = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $createdByUser = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $updatedByUser = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $comment = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?iterable $sprintInstances = [];

    #[Groups(['ProjectInstance:item:read'])]
    public ?iterable $projectInstances = [];

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $parent = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $configFramework = null;
}
