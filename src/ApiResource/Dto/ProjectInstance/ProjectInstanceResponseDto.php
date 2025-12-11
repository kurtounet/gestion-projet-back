<?php

namespace App\ApiResource\Dto\ProjectInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ProjectInstance.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'ProjectInstance',
    stateOptions: new Options(entityClass: ProjectInstance::class),
)]
#[Map(source: ProjectInstance::class)]
final class ProjectInstanceResponseDto
{
    #[Groups(['ProjectInstance:read'])]
    public int $id;

    #[Groups(['ProjectInstance:read'])]
    public string $name;

    #[Groups(['ProjectInstance:read'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:read'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:read'])]
    public ?string $description;

    #[Groups(['ProjectInstance:read'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:read'])]
    public ?string $color;

    #[Groups(['ProjectInstance:read'])]
    public bool $isFavory;

    #[Groups(['ProjectInstance:read'])]
    public int $position;

    #[Groups(['ProjectInstance:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['ProjectInstance:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['ProjectInstance:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:read'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:read'])]
    public ?string $updatedByUser;
}
