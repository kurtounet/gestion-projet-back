<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour File.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class FileCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $path;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $keyWord;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;


}
