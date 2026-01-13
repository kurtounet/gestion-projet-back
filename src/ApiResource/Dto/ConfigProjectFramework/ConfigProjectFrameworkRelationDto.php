<?php

namespace App\ApiResource\Dto\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkRelationDto
{
    #[Groups(['ConfigProjectFramework:relation:read'])]
    public int $id;
}
