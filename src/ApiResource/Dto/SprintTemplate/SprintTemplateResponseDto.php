<?php

namespace App\ApiResource\Dto\SprintTemplate;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour SprintTemplate.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'SprintTemplate',
    stateOptions: new Options(entityClass: SprintTemplate::class),
)]
#[Map(source: SprintTemplate::class)]
final class SprintTemplateResponseDto
{
    #[Groups(['SprintTemplate:read'])]
    public int $id;

    #[Groups(['SprintTemplate:read'])]
    public string $name;

    #[Groups(['SprintTemplate:read'])]
    public string $description;

    #[Groups(['SprintTemplate:read'])]
    public int $duration;

    #[Groups(['SprintTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;
}
