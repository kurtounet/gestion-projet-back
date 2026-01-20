<?php

namespace App\ApiResource\Dto\Framework;

use App\Entity\Framework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Framework::class)]
final class FrameworkRelationDto
{
    #[Groups(['Framework:relation:read'])]
    public int $id;
}
