<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour ProjectTemplate.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: ProjectTemplate::class)]
final class ProjectTemplateUpdateDto
{
    #[Groups(['ProjectTemplate:update'])]
    public ?string $name;

    #[Groups(['ProjectTemplate:update'])]
    public ?string $description;

    #[Groups(['ProjectTemplate:update'])]
    public ?int $duration;

    #[Groups(['ProjectTemplate:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:update'])]
    public ?\DateTimeInterface $updatedAt;
}
