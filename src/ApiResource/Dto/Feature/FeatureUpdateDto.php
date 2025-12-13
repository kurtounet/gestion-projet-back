<?php

namespace App\ApiResource\Dto\Feature;

use App\Entity\Feature;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Feature.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: Feature::class)]
final class FeatureUpdateDto
{
    #[Groups(['Feature:update'])]
    public ?string $label;

    #[Groups(['Feature:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Feature:update'])]
    public ?\DateTimeInterface $updatedAt;
}
