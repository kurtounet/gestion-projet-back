<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour SprintInstance.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: SprintInstance::class)]
final class SprintInstanceUpdateDto
{
    #[Groups(['SprintInstance:update'])]
    public ?string $name;

    #[Groups(['SprintInstance:update'])]
    public ?string $description;

    #[Groups(['SprintInstance:update'])]
    public ?string $icon;

    #[Groups(['SprintInstance:update'])]
    public ?string $color;

    #[Groups(['SprintInstance:update'])]
    public ?\DateTimeInterface $startDate;

    #[Groups(['SprintInstance:update'])]
    public ?\DateTimeInterface $endDate;

    #[Groups(['SprintInstance:update'])]
    public ?int $position;

    #[Groups(['SprintInstance:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:update'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:update'])]
    public ?string $updatedByUser;
}
