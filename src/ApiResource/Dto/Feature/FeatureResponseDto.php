<?php

namespace App\ApiResource\Dto\Feature;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Feature;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Feature.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Feature',
    stateOptions: new Options(entityClass: Feature::class),
)]
#[Map(source: Feature::class)]
final class FeatureResponseDto
{
    #[Groups(['Feature:read'])]
    public int $id;

    #[Groups(['Feature:read'])]
    public string $label;

    #[Groups(['Feature:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:read'])]
    public ?\DateTimeInterface $updatedAt;
}
