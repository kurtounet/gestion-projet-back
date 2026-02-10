<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Framework::class)]
final class FrameworkItemDto
{
    #[Groups(['Framework:item:read'])]
    public int $id;

    #[Groups(['Framework:item:read'])]
    public string $label;

    #[Groups(['Framework:item:read'])]
    public string $type;

    #[Groups(['Framework:item:read'])]
    public string $version;

    #[Groups(['Framework:item:read'])]
    public ?string $description;

    #[Groups(['Framework:item:read'])]
    public ?array $configuration;

    #[Groups(['Framework:item:read'])]
    public ?string $icon;

    #[Groups(['Framework:item:read'])]
    public ?string $color;

    #[Groups(['Framework:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Framework:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Framework:item:read'])]
    public iterable $configProjectFrameworks = [];

    #[Groups(['Framework:item:read'])]
    public ?string $technology = null;
}
