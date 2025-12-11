<?php

namespace App\ApiResource\Dto\ProjectInstance;

use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectInstance.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: ProjectInstance::class)]
final class ProjectInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public string $name;

    #[Groups(['ProjectInstance:create'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:create'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:create'])]
    public ?string $description;

    #[Groups(['ProjectInstance:create'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:create'])]
    public ?string $color;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public bool $isFavory;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public int $position;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public \DateTimeInterface $endDate;

    #[Assert\NotBlank]
    #[Groups(['ProjectInstance:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:create'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:create'])]
    public ?string $updatedByUser;
}
