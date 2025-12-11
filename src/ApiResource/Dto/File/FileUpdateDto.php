<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour File.
 * Utilisé typiquement pour PATCH/PUT.
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
