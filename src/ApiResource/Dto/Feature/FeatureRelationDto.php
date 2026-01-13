<?php

namespace App\ApiResource\Dto\Feature;

use App\Entity\Feature;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Feature::class)]
final class FeatureRelationDto
{
    #[Groups(['Feature:relation:read'])]
    public int $id;
}
