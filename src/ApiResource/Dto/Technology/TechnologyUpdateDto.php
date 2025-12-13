<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Technology.
 * Utilisé typiquement pour PATCH/PUT.
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
