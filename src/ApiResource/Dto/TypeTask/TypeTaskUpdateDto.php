<?php

namespace App\ApiResource\Dto\TypeTask;

use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour TypeTask.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TypeTask::class)]
final class TypeTaskUpdateDto
{
    #[Groups(['TypeTask:update'])]
    public ?string $name;

    #[Groups(['TypeTask:update'])]
    public ?string $color;

    #[Groups(['TypeTask:update'])]
    public ?string $pathFileScript;

    #[Groups(['TypeTask:update'])]
    public ?string $description;

    #[Groups(['TypeTask:update'])]
    public ?bool $automatique;

    #[Groups(['TypeTask:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['TypeTask:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TypeTask:update'])]
    public ?string $code;
}
