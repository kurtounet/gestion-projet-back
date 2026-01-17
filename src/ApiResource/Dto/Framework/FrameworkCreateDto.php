<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Framework.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Framework::class)]
final class FrameworkCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Framework:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['Framework:create'])]
    public string $version;

    #[Groups(['Framework:create'])]
    public ?array $configuration;

    #[Groups(['Framework:create'])]
    public ?string $icon;

    #[Groups(['Framework:create'])]
    public ?string $color;



    #[Groups(['Framework:create'])]
    public ?string $technology;
}
