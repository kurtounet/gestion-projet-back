<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour CodeBase.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: CodeBase::class)]
final class CodeBaseCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['CodeBase:create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['CodeBase:create'])]
    public string $code;

    #[Assert\NotBlank]
    #[Groups(['CodeBase:create'])]
    public string $pathFile;

    #[Assert\NotBlank]
    #[Groups(['CodeBase:create'])]
    public string $feature;

    #[Assert\NotBlank]
    #[Groups(['CodeBase:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['CodeBase:create'])]
    public ?\DateTimeInterface $updatedAt;


}
