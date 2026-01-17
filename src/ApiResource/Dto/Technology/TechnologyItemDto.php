<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Technology::class)]
final class TechnologyItemDto
{
    #[Groups(['Technology:item:read'])]
    public int $id;

    #[Groups(['Technology:item:read'])]
    public string $label;

    #[Groups(['Technology:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Technology:item:read'])]
    public iterable $framework = [];

}
