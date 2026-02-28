<?php

namespace App\ApiResource\Dto\SprintTemplate;

use App\Entity\SprintTemplate;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintTemplate.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class SprintTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public int $duration;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;


}
