<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Priority.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Priority::class)]
final class PriorityUpdateDto
{
    #[Groups(['Priority:update'])]
    public ?string $label;

    #[Groups(['Priority:update'])]
    public ?string $color;

    #[Groups(['Priority:update'])]
    public ?int $priorityNumber;

    #[Groups(['Priority:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Priority:update'])]
    public ?\DateTimeInterface $updatedAt;
}
