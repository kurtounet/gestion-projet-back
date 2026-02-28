<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ContextStatus.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ContextStatusCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public ?string $context = null;
    #[Groups(['create'])]
    public ?string $status = null;
}
