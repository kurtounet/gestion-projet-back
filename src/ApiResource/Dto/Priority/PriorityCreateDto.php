<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Priority.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Priority::class)]
final class PriorityCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Priority:create'])]
    public string $label;

    #[Groups(['Priority:create'])]
    public ?string $color;

    #[Assert\NotBlank]
    #[Groups(['Priority:create'])]
    public int $priorityNumber;

    #[Assert\NotBlank]
    #[Groups(['Priority:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:create'])]
    public ?\DateTimeInterface $updatedAt;
}
