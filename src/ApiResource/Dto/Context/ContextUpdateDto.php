<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Context.
 * Utilisé typiquement pour PATCH/PUT.
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
