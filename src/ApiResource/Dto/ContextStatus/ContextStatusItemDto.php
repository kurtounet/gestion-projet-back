<?php

namespace App\ApiResource\Dto\ContextStatus;

use App\Entity\ContextStatus;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ContextStatus::class)]
final class ContextStatusItemDto
{
    #[Groups(['ContextStatus:item:read'])]
    public int $id;

    #[Groups(['ContextStatus:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ContextStatus:item:read'])]
    public ?string $context = null;

    #[Groups(['ContextStatus:item:read'])]
    public ?string $status = null;

}
