<?php

namespace App\ApiResource\Dto\CodeBase;

use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: CodeBase::class)]
final class CodeBaseRelationDto
{
    #[Groups(['CodeBase:relation:read'])]
    public int $id;
}
