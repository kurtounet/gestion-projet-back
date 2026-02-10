<?php

namespace App\ApiResource\Dto\Feature;

use App\Entity\Feature;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Feature::class)]
final class FeatureCollectionItemDto
{
    #[Groups(['Feature:collection:read'])]
    public int $id;

    #[Groups(['Feature:collection:read'])]
    public string $label;

    #[Groups(['Feature:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
