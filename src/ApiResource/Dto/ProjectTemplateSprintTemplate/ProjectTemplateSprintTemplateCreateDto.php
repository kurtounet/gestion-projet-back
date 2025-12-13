<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour ProjectTemplateSprintTemplate.
 * Utilisé typiquement comme input pour les opérations POST.
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
}
