<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: ProjectTemplate::class)]
final class ProjectTemplateItemDto
{
    #[Groups(['ProjectTemplate:item:read'])]
    public int $id;

    #[Groups(['ProjectTemplate:item:read'])]
    public string $name;

    #[Groups(['ProjectTemplate:item:read'])]
    public string $description;

    #[Groups(['ProjectTemplate:item:read'])]
    public int $duration;

    #[Groups(['ProjectTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
