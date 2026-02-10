<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Context.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Context::class)]
final class ContextCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Context:create'])]
    public string $contextLabel;

    #[Assert\NotBlank]
    #[Groups(['Context:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Context:create'])]
    public ?\DateTimeInterface $updatedAt;
}
