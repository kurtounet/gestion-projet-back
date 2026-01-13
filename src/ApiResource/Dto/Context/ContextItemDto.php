<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Context::class)]
final class ContextItemDto
{
    #[Groups(['Context:item:read'])]
    public int $id;

    #[Groups(['Context:item:read'])]
    public string $contextLabel;

    #[Groups(['Context:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Context:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
