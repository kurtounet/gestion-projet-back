<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintInstance.
 * Utilisé typiquement comme input pour les opérations POST.
 */
#[Map(target: SprintInstance::class)]
final class SprintInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public string $icon;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public string $color;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:create'])]
    public ?int $position;

    #[Assert\NotBlank]
    #[Groups(['SprintInstance:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:create'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:create'])]
    public ?string $updatedByUser;
}
