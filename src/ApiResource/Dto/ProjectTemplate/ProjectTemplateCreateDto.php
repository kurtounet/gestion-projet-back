<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectTemplate.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: ProjectTemplate::class)]
final class ProjectTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ProjectTemplate:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['ProjectTemplate:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['ProjectTemplate:create'])]
    public int $duration;

    #[Assert\NotBlank]
    #[Groups(['ProjectTemplate:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:create'])]
    public ?\DateTimeInterface $updatedAt;
}
