<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Framework::class)]
final class FrameworkCollectionItemDto
{
    #[Groups(['Framework:collection:read'])]
    public int $id;

    #[Groups(['Framework:collection:read'])]
    public string $name;

    #[Groups(['Framework:collection:read'])]
    public string $version;

    #[Groups(['Framework:collection:read'])]
    public ?array $configuration;

    #[Groups(['Framework:collection:read'])]
    public ?string $icon;

    #[Groups(['Framework:collection:read'])]
    public ?string $color;
}
