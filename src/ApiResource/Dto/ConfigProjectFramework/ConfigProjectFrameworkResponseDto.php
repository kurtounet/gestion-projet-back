<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\ConfigProjectFramework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ConfigProjectFramework.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'ConfigProjectFramework',
    stateOptions: new Options(entityClass: ConfigProjectFramework::class),
)]
#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkResponseDto
{
    #[Groups(['ConfigProjectFramework:read'])]
    public int $id;

    #[Groups(['ConfigProjectFramework:read'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:read'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:read'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:read'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:read'])]
    public ?\DateTimeInterface $updatedAt;
}
