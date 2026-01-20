<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: SprintTemplate::class)]
final class SprintTemplateCollectionItemDto
{
    #[Groups(['SprintTemplate:collection:read'])]
    public int $id;

    #[Groups(['SprintTemplate:collection:read'])]
    public string $name;

    #[Groups(['SprintTemplate:collection:read'])]
    public string $description;

    #[Groups(['SprintTemplate:collection:read'])]
    public int $duration;

    #[Groups(['SprintTemplate:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
