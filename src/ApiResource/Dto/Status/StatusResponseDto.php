<?php

namespace App\ApiResource\Dto\Status;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Status.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Status',
    stateOptions: new Options(entityClass: Status::class),
)]
#[Map(source: Status::class)]
final class StatusResponseDto
{
    #[Groups(['Status:read'])]
    public int $id;

    #[Groups(['Status:read'])]
    public string $label;

    #[Groups(['Status:read'])]
    public ?string $color;

    #[Groups(['Status:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Status:read'])]
    public ?\DateTimeInterface $updatedAt;
}
