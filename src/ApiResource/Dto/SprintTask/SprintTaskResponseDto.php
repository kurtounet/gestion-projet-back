<?php

namespace App\ApiResource\Dto\SprintTask;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\SprintTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour SprintTask.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'SprintTask',
    stateOptions: new Options(entityClass: SprintTask::class),
)]
#[Map(source: SprintTask::class)]
final class SprintTaskResponseDto
{
    #[Groups(['SprintTask:read'])]
    public int $id;

    #[Groups(['SprintTask:read'])]
    public int $taskOrder;

    #[Groups(['SprintTask:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:read'])]
    public ?\DateTimeInterface $updatedAt;
}
