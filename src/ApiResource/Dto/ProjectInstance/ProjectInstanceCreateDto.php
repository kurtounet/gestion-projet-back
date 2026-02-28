<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectInstance.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ProjectInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $name;

    #[Groups(['create'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['create'])]
    public ?string $pathProject = null;

    #[Groups(['create'])]
    public ?string $description = null;

    #[Groups(['create'])]
    public ?string $icon = null;

    #[Groups(['create'])]
    public ?string $color = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public bool $isFavory;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public int $position;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $endDate;

    #[Groups(['create'])]
    public ?string $createdByUser = null;

    #[Groups(['create'])]
    public ?string $updatedByUser = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['create'])]
    public ?string $status = null;

    #[Groups(['create'])]
    public ?string $priority = null;

    #[Groups(['create'])]
    public ?string $projectTemplate = null;

    #[Groups(['create'])]
    public ?string $comment = null;

    #[Groups(['create'])]
    public iterable $sprintInstances = [];

    #[Groups(['create'])]
    public iterable $projectInstances = [];

    #[Groups(['create'])]
    public ?string $parent = null;

    #[Groups(['create'])]
    public ?string $configFramework = null;
}
