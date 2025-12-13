<?php

namespace App\ApiResource\Dto\ContextStatus;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ContextStatus.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'ContextStatus',
    stateOptions: new Options(entityClass: ContextStatus::class),
)]
#[Map(source: ContextStatus::class)]
final class ContextStatusResponseDto
{
    #[Groups(['ContextStatus:read'])]
    public int $id;

    #[Groups(['ContextStatus:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:read'])]
    public ?\DateTimeInterface $updatedAt;
}
