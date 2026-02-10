<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Status.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Status::class)]
final class StatusUpdateDto
{
    #[Groups(['Status:update'])]
    public ?string $label;

    #[Groups(['Status:update'])]
    public ?string $color;

    #[Groups(['Status:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Status:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Status:update'])]
    public ?string $context;
}
