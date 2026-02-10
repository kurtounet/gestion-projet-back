<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Status::class)]
final class StatusCollectionItemDto
{
    #[Groups(['Status:collection:read'])]
    public int $id;

    #[Groups(['Status:collection:read'])]
    public string $label;

    #[Groups(['Status:collection:read'])]
    public ?string $color;

    #[Groups(['Status:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Status:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
