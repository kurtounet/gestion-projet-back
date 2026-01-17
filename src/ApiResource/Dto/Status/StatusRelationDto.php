<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Status::class)]
final class StatusRelationDto
{
    #[Groups(['Status:relation:read'])]
    public int $id;
}
