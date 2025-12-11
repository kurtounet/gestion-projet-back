<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\ProjectTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ProjectTemplate.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'ProjectTemplate',
    stateOptions: new Options(entityClass: ProjectTemplate::class),
)]
#[Map(source: ProjectTemplate::class)]
final class ProjectTemplateResponseDto
{
    #[Groups(['ProjectTemplate:read'])]
    public int $id;

    #[Groups(['ProjectTemplate:read'])]
    public string $name;

    #[Groups(['ProjectTemplate:read'])]
    public string $description;

    #[Groups(['ProjectTemplate:read'])]
    public int $duration;

    #[Groups(['ProjectTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;
}
