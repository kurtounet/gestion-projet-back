<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Framework.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Framework::class)]
final class FrameworkUpdateDto
{
    #[Groups(['Framework:update'])]
    public ?string $label;

    #[Groups(['Framework:update'])]
    public ?string $type;

    #[Groups(['Framework:update'])]
    public ?string $version;

    #[Groups(['Framework:update'])]
    public ?string $description;

    #[Groups(['Framework:update'])]
    public ?array $configuration;

    #[Groups(['Framework:update'])]
    public ?string $icon;

    #[Groups(['Framework:update'])]
    public ?string $color;

    #[Groups(['Framework:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Framework:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Framework:update'])]
    public ?string $technology;
}
