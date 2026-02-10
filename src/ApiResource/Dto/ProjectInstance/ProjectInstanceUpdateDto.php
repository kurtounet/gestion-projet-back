<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour ProjectInstance.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ProjectInstance::class)]
final class ProjectInstanceUpdateDto
{
    #[Groups(['ProjectInstance:update'])]
    public ?string $name;

    #[Groups(['ProjectInstance:update'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:update'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:update'])]
    public ?string $description;

    #[Groups(['ProjectInstance:update'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:update'])]
    public ?string $color;

    #[Groups(['ProjectInstance:update'])]
    public ?bool $isFavory;

    #[Groups(['ProjectInstance:update'])]
    public ?int $position;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $startDate;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $endDate;

    #[Groups(['ProjectInstance:update'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:update'])]
    public ?string $updatedByUser;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:update'])]
    public ?string $status;
    #[Groups(['ProjectInstance:update'])]
    public ?string $priority;
    #[Groups(['ProjectInstance:update'])]
    public ?string $projectTemplate;
    #[Groups(['ProjectInstance:update'])]
    public ?string $comment;
    #[Groups(['ProjectInstance:update'])]
    public ?string $parent;
    #[Groups(['ProjectInstance:update'])]
    public ?string $configFramework;
}
