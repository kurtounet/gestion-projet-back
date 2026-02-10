<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour ConfigProjectFramework.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkUpdateDto
{
    #[Groups(['ConfigProjectFramework:update'])]
    public ?string $name;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?string $projectInstance;

    #[Groups(['ConfigProjectFramework:update'])]
    public ?string $framework;
}
