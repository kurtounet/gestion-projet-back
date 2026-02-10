<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour File.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: File::class)]
final class FileUpdateDto
{
    #[Groups(['File:update'])]
    public ?string $path;

    #[Groups(['File:update'])]
    public ?string $keyWord;

    #[Groups(['File:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['File:update'])]
    public ?\DateTimeInterface $updatedAt;
}
