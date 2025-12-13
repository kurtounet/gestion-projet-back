<?php

namespace App\ApiResource\Dto\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour ProjectTemplateSprintTemplate.
 * Utilisé typiquement pour PATCH/PUT.
 */
#[Map(target: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateUpdateDto
{
    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:update'])]
    public ?\DateTimeInterface $updatedAt;
}
