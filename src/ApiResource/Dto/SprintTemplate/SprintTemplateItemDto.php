<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: SprintTemplate::class)]
final class SprintTemplateItemDto
{
    #[Groups(['SprintTemplate:item:read'])]
    public int $id;

    #[Groups(['SprintTemplate:item:read'])]
    public string $name;

    #[Groups(['SprintTemplate:item:read'])]
    public string $description;

    #[Groups(['SprintTemplate:item:read'])]
    public int $duration;

    #[Groups(['SprintTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
