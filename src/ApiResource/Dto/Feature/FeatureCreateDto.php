<?php

namespace App\ApiResource\Dto\Feature;

use App\Entity\Feature;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Feature.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: Feature::class)]
final class FeatureCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Feature:create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['Feature:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:create'])]
    public ?\DateTimeInterface $updatedAt;
}
