<?php

namespace App\ApiResource\Dto\TypeTask;

use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour TypeTask.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TypeTask::class)]
final class TypeTaskCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['TypeTask:create'])]
    public string $name;

    #[Groups(['TypeTask:create'])]
    public ?string $color;

    #[Assert\NotBlank]
    #[Groups(['TypeTask:create'])]
    public string $pathFileScript;

    #[Assert\NotBlank]
    #[Groups(['TypeTask:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['TypeTask:create'])]
    public bool $automatique;

    #[Assert\NotBlank]
    #[Groups(['TypeTask:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TypeTask:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TypeTask:create'])]
    public ?string $code;
}
