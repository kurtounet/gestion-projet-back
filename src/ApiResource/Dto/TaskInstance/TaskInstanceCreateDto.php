<?php

namespace App\ApiResource\Dto\TaskInstance;

use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour TaskInstance.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: TaskInstance::class)]
final class TaskInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public string $name;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public string $description;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:create'])]
    public ?int $position;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public string $icon;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public string $color;

    #[Assert\NotBlank]
    #[Groups(['TaskInstance:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:create'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:create'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:create'])]
    public ?string $updatedByUser;

    #[Groups(['TaskInstance:create'])]
    public ?string $user;
    #[Groups(['TaskInstance:create'])]
    public ?string $taskTemplate;
    #[Groups(['TaskInstance:create'])]
    public ?string $sprintInstance;
    #[Groups(['TaskInstance:create'])]
    public ?string $priority;
    #[Groups(['TaskInstance:create'])]
    public ?string $status;
    #[Groups(['TaskInstance:create'])]
    public ?string $typeTask;
    #[Groups(['TaskInstance:create'])]
    public ?string $parentTask;
    #[Groups(['TaskInstance:create'])]
    public ?string $dependency;
    #[Groups(['TaskInstance:create'])]
    public ?string $comment;
}
