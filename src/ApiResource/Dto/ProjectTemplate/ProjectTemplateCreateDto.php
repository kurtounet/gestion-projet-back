<?php

namespace App\ApiResource\Dto\ProjectTemplate;

use App\Entity\ProjectTemplate;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectTemplate.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ProjectTemplateCreateDto
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
