<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour ContextStatus.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: ContextStatus::class)]
final class ContextStatusUpdateDto
{
    #[Groups(['ContextStatus:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:update'])]
    public ?\DateTimeInterface $updatedAt;
}
