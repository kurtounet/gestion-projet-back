<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Context::class)]
final class ContextCollectionItemDto
{
    #[Groups(['Context:collection:read'])]
    public int $id;

    #[Groups(['Context:collection:read'])]
    public string $contextLabel;

    #[Groups(['Context:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Context:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
