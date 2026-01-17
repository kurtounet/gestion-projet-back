<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: CodeBase::class)]
final class CodeBaseItemDto
{
    #[Groups(['CodeBase:item:read'])]
    public int $id;

    #[Groups(['CodeBase:item:read'])]
    public string $label;

    #[Groups(['CodeBase:item:read'])]
    public string $code;

    #[Groups(['CodeBase:item:read'])]
    public string $pathFile;

    #[Groups(['CodeBase:item:read'])]
    public string $feature;

    #[Groups(['CodeBase:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['CodeBase:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
