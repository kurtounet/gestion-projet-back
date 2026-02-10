<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Technology.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Technology::class)]
final class TechnologyUpdateDto
{
    #[Groups(['Technology:update'])]
    public ?string $label;

    #[Groups(['Technology:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Technology:update'])]
    public ?\DateTimeInterface $updatedAt;
}
