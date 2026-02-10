<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Priority::class)]
final class PriorityCollectionItemDto
{
    #[Groups(['Priority:collection:read'])]
    public int $id;

    #[Groups(['Priority:collection:read'])]
    public string $label;

    #[Groups(['Priority:collection:read'])]
    public ?string $color;

    #[Groups(['Priority:collection:read'])]
    public int $priorityNumber;

    #[Groups(['Priority:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
