<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Status.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class StatusCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $label;

    #[Groups(['create'])]
    public ?string $color = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public ?string $context = null;
}
