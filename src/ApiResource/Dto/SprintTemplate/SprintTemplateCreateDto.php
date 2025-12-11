<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintTemplate.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: SprintTemplate::class)]
final class SprintTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['SprintTemplate:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['SprintTemplate:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['SprintTemplate:create'])]
    public int $duration;

    #[Assert\NotBlank]
    #[Groups(['SprintTemplate:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:create'])]
    public ?\DateTimeInterface $updatedAt;
}
