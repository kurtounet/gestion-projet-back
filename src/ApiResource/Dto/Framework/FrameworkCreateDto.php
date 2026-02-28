<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Framework.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class FrameworkCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $type;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $version;

    #[Groups(['create'])]
    public ?string $description = null;

    #[Groups(['create'])]
    public ?array $configuration = null;

    #[Groups(['create'])]
    public ?string $icon = null;

    #[Groups(['create'])]
    public ?string $color = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public iterable $configProjectFrameworks = [];
    #[Groups(['create'])]
    public ?string $technology = null;
}
