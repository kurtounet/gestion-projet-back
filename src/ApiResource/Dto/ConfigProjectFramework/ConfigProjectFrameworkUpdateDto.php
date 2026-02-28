<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour ConfigProjectFramework.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ConfigProjectFrameworkUpdateDto
{
    #[Groups(['update'])]
    public ?string $name = null;

    #[Groups(['update'])]
    public ?array $configuration = null;

    #[Groups(['update'])]
    public ?array $architecture = null;

    #[Groups(['update'])]
    public ?array $script = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $projectInstance = null;
    #[Groups(['update'])]
    public ?string $framework = null;
}
