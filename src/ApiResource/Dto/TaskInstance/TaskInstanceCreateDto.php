<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour TaskInstance.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class TaskInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['create'])]
    public ?int $position = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $icon;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $color;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['create'])]
    public ?string $createdByUser = null;

    #[Groups(['create'])]
    public ?string $updatedByUser = null;



    #[Groups(['create'])]
    public ?string $user = null;
    #[Groups(['create'])]
    public ?string $taskTemplate = null;
    #[Groups(['create'])]
    public ?string $sprintInstance = null;
    #[Groups(['create'])]
    public ?string $priority = null;
    #[Groups(['create'])]
    public ?string $status = null;
    #[Groups(['create'])]
    public ?string $typeTask = null;
    #[Groups(['create'])]
    public ?string $parentTask = null;
    #[Groups(['create'])]
    public ?string $dependency = null;
    #[Groups(['create'])]
    public ?string $comment = null;
}
