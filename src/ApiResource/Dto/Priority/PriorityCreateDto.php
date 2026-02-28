<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Priority.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class PriorityCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $label;

    #[Groups(['create'])]
    public ?string $color = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public int $priorityNumber;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;


}
