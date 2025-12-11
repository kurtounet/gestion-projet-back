<?php

namespace App\ApiResource\Dto\CodeBase;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour CodeBase.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'CodeBase',
    stateOptions: new Options(entityClass: CodeBase::class),
)]
#[Map(source: CodeBase::class)]
final class CodeBaseResponseDto
{
    #[Groups(['CodeBase:read'])]
    public int $id;

    #[Groups(['CodeBase:read'])]
    public string $label;

    #[Groups(['CodeBase:read'])]
    public string $code;

    #[Groups(['CodeBase:read'])]
    public string $pathFile;

    #[Groups(['CodeBase:read'])]
    public string $feature;

    #[Groups(['CodeBase:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['CodeBase:read'])]
    public ?\DateTimeInterface $updatedAt;
}
