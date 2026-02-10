<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: ContextStatus::class)]
final class ContextStatusCollectionItemDto
{
    #[Groups(['ContextStatus:collection:read'])]
    public int $id;

    #[Groups(['ContextStatus:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
