<?php

namespace App\ApiResource\Dto\Priority;

use App\Entity\Priority;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Priority::class)]
final class PriorityItemDto
{
    #[Groups(['Priority:item:read'])]
    public int $id;

    #[Groups(['Priority:item:read'])]
    public string $label;

    #[Groups(['Priority:item:read'])]
    public ?string $color;

    #[Groups(['Priority:item:read'])]
    public int $priorityNumber;

    #[Groups(['Priority:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
