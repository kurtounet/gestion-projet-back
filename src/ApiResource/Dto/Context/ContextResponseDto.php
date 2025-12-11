<?php

namespace App\ApiResource\Dto\Context;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Context.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Context',
    stateOptions: new Options(entityClass: Context::class),
)]
#[Map(source: Context::class)]
final class ContextResponseDto
{
    #[Groups(['Context:read'])]
    public int $id;

    #[Groups(['Context:read'])]
    public string $contextLabel;

    #[Groups(['Context:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Context:read'])]
    public ?\DateTimeInterface $updatedAt;
}
