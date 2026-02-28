<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour File.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class FileUpdateDto
{
    #[Groups(['update'])]
    public ?string $path = null;

    #[Groups(['update'])]
    public ?string $keyWord = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;
}
