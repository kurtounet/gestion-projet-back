<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour CodeBase.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: CodeBase::class)]
final class CodeBaseUpdateDto
{
    #[Groups(['CodeBase:update'])]
    public ?string $label;

    #[Groups(['CodeBase:update'])]
    public ?string $code;

    #[Groups(['CodeBase:update'])]
    public ?string $pathFile;

    #[Groups(['CodeBase:update'])]
    public ?string $feature;

    #[Groups(['CodeBase:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['CodeBase:update'])]
    public ?\DateTimeInterface $updatedAt;
}
