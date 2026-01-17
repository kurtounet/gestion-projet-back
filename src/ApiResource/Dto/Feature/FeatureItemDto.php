<?php

namespace App\ApiResource\Dto\Feature;

use App\Entity\Feature;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Feature::class)]
final class FeatureItemDto
{
    #[Groups(['Feature:item:read'])]
    public int $id;

    #[Groups(['Feature:item:read'])]
    public string $label;

    #[Groups(['Feature:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:item:read'])]
    public ?\DateTimeInterface $updatedAt;


}
