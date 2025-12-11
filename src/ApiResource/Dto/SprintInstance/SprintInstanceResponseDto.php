<?php

namespace App\ApiResource\Dto\SprintInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour SprintInstance.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'SprintInstance',
    stateOptions: new Options(entityClass: SprintInstance::class),
)]
#[Map(source: SprintInstance::class)]
final class SprintInstanceResponseDto
{
    #[Groups(['SprintInstance:read'])]
    public int $id;

    #[Groups(['SprintInstance:read'])]
    public string $name;

    #[Groups(['SprintInstance:read'])]
    public string $description;

    #[Groups(['SprintInstance:read'])]
    public string $icon;

    #[Groups(['SprintInstance:read'])]
    public string $color;

    #[Groups(['SprintInstance:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['SprintInstance:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:read'])]
    public ?int $position;

    #[Groups(['SprintInstance:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:read'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:read'])]
    public ?string $updatedByUser;
}
