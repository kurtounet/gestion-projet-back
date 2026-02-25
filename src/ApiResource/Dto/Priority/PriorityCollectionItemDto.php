<?php

namespace App\ApiResource\Dto\Priority;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\ApiResource\Resource\Priority\PriorityResource;
use App\Entity\Priority;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

final class PriorityCollectionItemDto
{
    #[Groups(['Priority:collection:read'])]
    #[ApiProperty(identifier: true)]
    public ?int $id;

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
