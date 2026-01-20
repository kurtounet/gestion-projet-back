<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: File::class)]
final class FileCollectionItemDto
{
    #[Groups(['File:collection:read'])]
    public int $id;

    #[Groups(['File:collection:read'])]
    public string $path;

    #[Groups(['File:collection:read'])]
    public string $keyWord;

    #[Groups(['File:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
