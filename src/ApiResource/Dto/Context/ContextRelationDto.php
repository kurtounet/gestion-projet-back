<?php

namespace App\ApiResource\Dto\Context;

use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Context::class)]
final class ContextRelationDto
{
    #[Groups(['Context:relation:read'])]
    public int $id;
}
