<?php

namespace App\ApiResource\Dto\Priority;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Priority.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Priority',
    stateOptions: new Options(entityClass: Priority::class),
)]
#[Map(source: Priority::class)]
final class PriorityResponseDto
{
    #[Groups(['Priority:read'])]
    public int $id;

    #[Groups(['Priority:read'])]
    public string $label;

    #[Groups(['Priority:read'])]
    public ?string $color;

    #[Groups(['Priority:read'])]
    public int $priorityNumber;

    #[Groups(['Priority:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:read'])]
    public ?\DateTimeInterface $updatedAt;
}
