<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour ProjectInstance.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
// #[Map(target: ProjectInstance::class)]
final class ProjectInstanceUpdateDto
{
    #[Groups(['ProjectInstance:update'])]
    public ?string $name = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $pathProject = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $description = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $icon = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $color = null;

    #[Groups(['ProjectInstance:update'])]
    public ?bool $favory = null;

    #[Groups(['ProjectInstance:update'])]
    public ?int $position = null;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $createdByUser = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $updatedByUser = null;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['ProjectInstance:update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $status = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $priority = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $comment = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $parent = null;

    #[Groups(['ProjectInstance:update'])]
    public ?string $configFramework = null;
}
