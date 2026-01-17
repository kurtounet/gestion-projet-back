<?php

namespace App\ApiResource\Dto\Technology;

use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Technology.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Technology::class)]
final class TechnologyCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Technology:create'])]
    public string $label;

    #[Assert\NotBlank]
    #[Groups(['Technology:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:create'])]
    public ?\DateTimeInterface $updatedAt;


}
