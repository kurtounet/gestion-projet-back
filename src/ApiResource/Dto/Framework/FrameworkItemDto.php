<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Framework::class)]
final class FrameworkItemDto
{
    #[Groups(['Framework:item:read'])]
    public int $id;

    #[Groups(['Framework:item:read'])]
    public string $name;

    #[Groups(['Framework:item:read'])]
    public string $version;

    #[Groups(['Framework:item:read'])]
    public ?array $configuration;

    #[Groups(['Framework:item:read'])]
    public ?string $icon;

    #[Groups(['Framework:item:read'])]
    public ?string $color;

    #[Groups(['Framework:item:read'])]
    public iterable $configProjectFrameworks = [];

    #[Groups(['Framework:item:read'])]
    public ?string $technology = null;

}
