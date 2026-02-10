<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: CodeBase::class)]
final class CodeBaseCollectionItemDto
{
    #[Groups(['CodeBase:collection:read'])]
    public int $id;

    #[Groups(['CodeBase:collection:read'])]
    public string $label;

    #[Groups(['CodeBase:collection:read'])]
    public string $code;

    #[Groups(['CodeBase:collection:read'])]
    public string $pathFile;

    #[Groups(['CodeBase:collection:read'])]
    public string $feature;

    #[Groups(['CodeBase:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['CodeBase:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
