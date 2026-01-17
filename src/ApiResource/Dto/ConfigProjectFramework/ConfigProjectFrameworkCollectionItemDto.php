<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkCollectionItemDto
{
    #[Groups(['ConfigProjectFramework:collection:read'])]
    public int $id;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
