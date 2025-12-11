<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Technology.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: Technology::class)]
final class TechnologyCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Technology:create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['Technology:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:create'])]
    public ?\DateTimeInterface $updatedAt;
}
