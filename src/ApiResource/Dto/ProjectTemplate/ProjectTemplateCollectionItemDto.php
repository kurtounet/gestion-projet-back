<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: ProjectTemplate::class)]
final class ProjectTemplateCollectionItemDto
{
    #[Groups(['ProjectTemplate:collection:read'])]
    public int $id;

    #[Groups(['ProjectTemplate:collection:read'])]
    public string $name;

    #[Groups(['ProjectTemplate:collection:read'])]
    public string $description;

    #[Groups(['ProjectTemplate:collection:read'])]
    public int $duration;

    #[Groups(['ProjectTemplate:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
