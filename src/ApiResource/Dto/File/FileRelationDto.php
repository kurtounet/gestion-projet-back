<?php

namespace App\ApiResource\Dto\File;

use App\Entity\File;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: File::class)]
final class FileRelationDto
{
    #[Groups(['File:relation:read'])]
    public int $id;
}
