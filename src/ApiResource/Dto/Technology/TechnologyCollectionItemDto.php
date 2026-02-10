<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Technology::class)]
final class TechnologyCollectionItemDto
{
    #[Groups(['Technology:collection:read'])]
    public int $id;

    #[Groups(['Technology:collection:read'])]
    public string $label;

    #[Groups(['Technology:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
