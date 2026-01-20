<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Context.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Context::class)]
final class ContextUpdateDto
{
    #[Groups(['Context:update'])]
    public ?string $contextLabel;

    #[Groups(['Context:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Context:update'])]
    public ?\DateTimeInterface $updatedAt;
}
