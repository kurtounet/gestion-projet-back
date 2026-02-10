<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ConfigProjectFramework.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ConfigProjectFramework:create'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:create'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:create'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:create'])]
    public ?array $script;

    #[Assert\NotBlank]
    #[Groups(['ConfigProjectFramework:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ConfigProjectFramework:create'])]
    public ?string $projectInstance;
    #[Groups(['ConfigProjectFramework:create'])]
    public ?string $framework;
}
