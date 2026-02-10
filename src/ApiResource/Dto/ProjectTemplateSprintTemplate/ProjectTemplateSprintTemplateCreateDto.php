<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectTemplateSprintTemplate.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['ProjectTemplateSprintTemplate:create'])]
    public int $sprintOrder;

    #[Assert\NotBlank]
    #[Groups(['ProjectTemplateSprintTemplate:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectTemplateSprintTemplate:create'])]
    public ?string $projectTemplate;
    #[Groups(['ProjectTemplateSprintTemplate:create'])]
    public ?string $sprintTemplate;
}
