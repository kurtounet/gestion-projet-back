<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ProjectTemplateSprintTemplate.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'ProjectTemplateSprintTemplate',
    stateOptions: new Options(entityClass: ProjectTemplateSprintTemplate::class),
)]
#[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateResponseDto
{
    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public int $id;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;
}
