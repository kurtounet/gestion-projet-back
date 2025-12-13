<?php

namespace App\ApiResource\Dto\Framework;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Framework.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Framework',
    stateOptions: new Options(entityClass: Framework::class),
)]
#[Map(source: Framework::class)]
final class FrameworkResponseDto
{
    #[Groups(['Framework:read'])]
    public int $id;

    #[Groups(['Framework:read'])]
    public string $name;

    #[Groups(['Framework:read'])]
    public string $version;

    #[Groups(['Framework:read'])]
    public ?array $configuration;

    #[Groups(['Framework:read'])]
    public ?string $icon;

    #[Groups(['Framework:read'])]
    public ?string $color;
}
