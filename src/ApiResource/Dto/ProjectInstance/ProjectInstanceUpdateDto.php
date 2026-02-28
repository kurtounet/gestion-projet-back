<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour ProjectInstance.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ProjectInstanceUpdateDto
{
    #[Groups(['update'])]
    public ?string $name = null;

    #[Groups(['update'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['update'])]
    public ?string $pathProject = null;

    #[Groups(['update'])]
    public ?string $description = null;

    #[Groups(['update'])]
    public ?string $icon = null;

    #[Groups(['update'])]
    public ?string $color = null;

    #[Groups(['update'])]
    public ?bool $isFavory = null;

    #[Groups(['update'])]
    public ?int $position = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups(['update'])]
    public ?string $createdByUser = null;

    #[Groups(['update'])]
    public ?string $updatedByUser = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $status = null;
    #[Groups(['update'])]
    public ?string $priority = null;
    #[Groups(['update'])]
    public ?string $projectTemplate = null;
    #[Groups(['update'])]
    public ?string $comment = null;
    #[Groups(['update'])]
    public iterable $sprintInstances = [];
    #[Groups(['update'])]
    public iterable $projectInstances = [];
    #[Groups(['update'])]
    public ?string $parent = null;
    #[Groups(['update'])]
    public ?string $configFramework = null;
}
