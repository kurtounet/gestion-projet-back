<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Status::class)]
final class StatusItemDto
{
    #[Groups(['Status:item:read'])]
    public int $id;

    #[Groups(['Status:item:read'])]
    public string $label;

    #[Groups(['Status:item:read'])]
    public ?string $color;

    #[Groups(['Status:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Status:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Status:item:read'])]
    public ?string $context = null;
}
