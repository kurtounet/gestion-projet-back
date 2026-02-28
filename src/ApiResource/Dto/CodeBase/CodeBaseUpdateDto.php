<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour CodeBase.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class CodeBaseUpdateDto
{
    #[Groups(['update'])]
    public ?string $label = null;

    #[Groups(['update'])]
    public ?string $code = null;

    #[Groups(['update'])]
    public ?string $pathFile = null;

    #[Groups(['update'])]
    public ?string $feature = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;
}
