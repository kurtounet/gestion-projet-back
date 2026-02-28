<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Framework.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class FrameworkUpdateDto
{
    #[Groups(['update'])]
    public ?string $label = null;

    #[Groups(['update'])]
    public ?string $type = null;

    #[Groups(['update'])]
    public ?string $version = null;

    #[Groups(['update'])]
    public ?string $description = null;

    #[Groups(['update'])]
    public ?array $configuration = null;

    #[Groups(['update'])]
    public ?string $icon = null;

    #[Groups(['update'])]
    public ?string $color = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public iterable $configProjectFrameworks = [];
    #[Groups(['update'])]
    public ?string $technology = null;
}
