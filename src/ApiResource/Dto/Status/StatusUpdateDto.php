<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Status.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class StatusUpdateDto
{
    #[Groups(['update'])]
    public ?string $label = null;

    #[Groups(['update'])]
    public ?string $color = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $context = null;
}
