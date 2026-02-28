<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Context.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ContextUpdateDto
{
    #[Groups(['update'])]
    public ?string $contextLabel = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;
}
