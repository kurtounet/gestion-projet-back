<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour CodeBase.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class CodeBaseCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $code;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $pathFile;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $feature;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;


}
