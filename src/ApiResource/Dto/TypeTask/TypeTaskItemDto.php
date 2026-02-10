<?php

namespace App\ApiResource\Dto\TypeTask;

use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: TypeTask::class)]
final class TypeTaskItemDto
{
    #[Groups(['TypeTask:item:read'])]
    public int $id;

    #[Groups(['TypeTask:item:read'])]
    public string $name;

    #[Groups(['TypeTask:item:read'])]
    public ?string $color;

    #[Groups(['TypeTask:item:read'])]
    public string $pathFileScript;

    #[Groups(['TypeTask:item:read'])]
    public string $description;

    #[Groups(['TypeTask:item:read'])]
    public bool $automatique;

    #[Groups(['TypeTask:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TypeTask:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TypeTask:item:read'])]
    public ?string $code = null;
}
