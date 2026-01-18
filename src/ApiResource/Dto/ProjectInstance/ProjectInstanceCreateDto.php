<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectInstance.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
// #[Map(target: ProjectInstance::class)]
final class ProjectInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public ?string $name = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $pathProject = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $description = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $icon = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $color = null;

    // #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public ?bool $isFavory = null;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public ?int $position = null;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public ?\DateTimeInterface $startDate = null;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $createdByUser = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $updatedByUser = null;

    // #[Assert\NotBlank]
    // #[Groups(['ProjectInstance:create'])]
    // public \DateTimeInterface $createdAt;

    // #[Groups(['ProjectInstance:create'])]
    // public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:create'])]
    public ?string $status = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $priority;

    #[Groups(['ProjectInstance:create'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $comment = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $parent = null;

    #[Groups(['ProjectInstance:create'])]
    public ?string $configFramework = null;
}
