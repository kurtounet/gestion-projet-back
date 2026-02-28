<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Priority.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class PriorityUpdateDto
{
    #[Groups(['update'])]
    public ?string $label = null;

    #[Groups(['update'])]
    public ?string $color = null;

    #[Groups(['update'])]
    public ?int $priorityNumber = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;
}
