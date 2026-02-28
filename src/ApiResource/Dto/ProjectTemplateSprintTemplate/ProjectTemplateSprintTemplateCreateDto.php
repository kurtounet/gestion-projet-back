<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectTemplateSprintTemplate.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class ProjectTemplateSprintTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public int $sprintOrder;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public ?string $projectTemplate = null;
    #[Groups(['create'])]
    public ?string $sprintTemplate = null;
}
