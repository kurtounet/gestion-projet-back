<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkItemDto
{
    #[Groups(['ConfigProjectFramework:item:read'])]
    public int $id;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?string $projectInstance = null;

    #[Groups(['ConfigProjectFramework:item:read'])]
    public ?string $framework = null;

}
