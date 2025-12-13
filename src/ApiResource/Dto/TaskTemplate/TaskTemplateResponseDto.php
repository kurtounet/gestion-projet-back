<?php

namespace App\ApiResource\Dto\TaskTemplate;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour TaskTemplate.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'TaskTemplate',
    stateOptions: new Options(entityClass: TaskTemplate::class),
)]
#[Map(source: TaskTemplate::class)]
final class TaskTemplateResponseDto
{
    #[Groups(['TaskTemplate:read'])]
    public int $id;

    #[Groups(['TaskTemplate:read'])]
    public string $name;

    #[Groups(['TaskTemplate:read'])]
    public string $description;

    #[Groups(['TaskTemplate:read'])]
    public int $parentTask;

    #[Groups(['TaskTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;
}
