<?php

namespace App\ApiResource\Dto\Status;

use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Status.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Status::class)]
final class StatusCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Status:create'])]
    public string $label;

    #[Groups(['Status:create'])]
    public ?string $color;

    #[Assert\NotBlank]
    #[Groups(['Status:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Status:create'])]
    public ?\DateTimeInterface $updatedAt;



    #[Groups(['Status:create'])]
    public ?string $context;
}
