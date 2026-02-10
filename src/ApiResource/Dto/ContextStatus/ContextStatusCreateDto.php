<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ContextStatus.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ContextStatus::class)]
final class ContextStatusCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ContextStatus:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ContextStatus:create'])]
    public ?string $context;
    #[Groups(['ContextStatus:create'])]
    public ?string $status;
}
