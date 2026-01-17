<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour File.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: File::class)]
final class FileCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['File:create'])]
    public string $path;

    #[Assert\NotBlank]
    #[Groups(['File:create'])]
    public string $keyWord;

    #[Assert\NotBlank]
    #[Groups(['File:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:create'])]
    public ?\DateTimeInterface $updatedAt;


}
