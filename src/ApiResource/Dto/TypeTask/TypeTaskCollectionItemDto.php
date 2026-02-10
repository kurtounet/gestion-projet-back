<?php

namespace App\ApiResource\Dto\TypeTask;

use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: TypeTask::class)]
final class TypeTaskCollectionItemDto
{
    #[Groups(['TypeTask:collection:read'])]
    public int $id;

    #[Groups(['TypeTask:collection:read'])]
    public string $name;

    #[Groups(['TypeTask:collection:read'])]
    public ?string $color;

    #[Groups(['TypeTask:collection:read'])]
    public string $pathFileScript;

    #[Groups(['TypeTask:collection:read'])]
    public string $description;

    #[Groups(['TypeTask:collection:read'])]
    public bool $automatique;

    #[Groups(['TypeTask:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TypeTask:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
