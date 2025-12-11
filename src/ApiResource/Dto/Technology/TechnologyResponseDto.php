<?php

namespace App\ApiResource\Dto\Technology;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Technology.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Technology',
    stateOptions: new Options(entityClass: Technology::class),
)]
#[Map(source: Technology::class)]
final class TechnologyResponseDto
{
    #[Groups(['Technology:read'])]
    public int $id;

    #[Groups(['Technology:read'])]
    public string $label;

    #[Groups(['Technology:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:read'])]
    public ?\DateTimeInterface $updatedAt;
}
