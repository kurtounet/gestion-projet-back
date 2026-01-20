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
    public string $name;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $description;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $color;

    #[Groups(['ProjectInstance:item:read'])]
    public bool $isFavory;

    #[Groups(['ProjectInstance:item:read'])]
    public int $position;

    #[Groups(['ProjectInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['ProjectInstance:item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['ProjectInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $comment = null;

    #[Groups(['ProjectInstance:item:read'])]
    public iterable $sprintInstances = [];

    #[Groups(['ProjectInstance:item:read'])]
    public iterable $projectInstances = [];

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $parent = null;

    #[Groups(['ProjectInstance:item:read'])]
    public ?string $configFramework = null;

}
