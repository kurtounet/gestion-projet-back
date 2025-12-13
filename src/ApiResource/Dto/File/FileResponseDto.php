<?php

namespace App\ApiResource\Dto\File;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour File.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'File',
    stateOptions: new Options(entityClass: File::class),
)]
#[Map(source: File::class)]
final class FileResponseDto
{
    #[Groups(['File:read'])]
    public int $id;

    #[Groups(['File:read'])]
    public string $path;

    #[Groups(['File:read'])]
    public string $keyWord;

    #[Groups(['File:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:read'])]
    public ?\DateTimeInterface $updatedAt;
}
