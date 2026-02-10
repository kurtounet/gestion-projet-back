<?php

namespace App\ApiResource\Dto\TaskTemplate;

use App\Entity\TaskTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour TaskTemplate.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TaskTemplate::class)]
final class TaskTemplateCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['TaskTemplate:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['TaskTemplate:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['TaskTemplate:create'])]
    public int $parentTask;

    #[Assert\NotBlank]
    #[Groups(['TaskTemplate:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskTemplate:create'])]
    public ?string $sprintTemplate;
    #[Groups(['TaskTemplate:create'])]
    public ?string $typeTask;
}
