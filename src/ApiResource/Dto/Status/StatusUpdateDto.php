<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Status.
 * Utilisé typiquement pour PATCH/PUT.
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
}
