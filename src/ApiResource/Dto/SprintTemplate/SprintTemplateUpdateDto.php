<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour SprintTemplate.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: SprintTemplate::class)]
final class SprintTemplateUpdateDto
{
    #[Groups(['SprintTemplate:update'])]
    public ?string $name;

    #[Groups(['SprintTemplate:update'])]
    public ?string $description;

    #[Groups(['SprintTemplate:update'])]
    public ?int $duration;

    #[Groups(['SprintTemplate:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:update'])]
    public ?\DateTimeInterface $updatedAt;
}
