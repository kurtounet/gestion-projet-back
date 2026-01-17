<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: File::class)]
final class FileItemDto
{
    #[Groups(['File:item:read'])]
    public int $id;

    #[Groups(['File:item:read'])]
    public string $path;

    #[Groups(['File:item:read'])]
    public string $keyWord;

    #[Groups(['File:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
