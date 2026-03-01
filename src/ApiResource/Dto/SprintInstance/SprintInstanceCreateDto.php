<?php

namespace App\ApiResource\Dto\SprintInstance;

use App\Entity\SprintInstance;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour SprintInstance.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class SprintInstanceCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $name;

    #[Groups(['create'])]
    public ?string $description = null;

    #[Groups(['create'])]
    public ?string $icon = null;

    #[Groups(['create'])]
    public string $color = "#000000";

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $startDate;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $endDate;

    #[Groups(['create'])]
    public ?int $position = null;
    /*
        #[Assert\NotBlank]
        #[Groups(['create'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['create'])]
        public ?\DateTimeInterface $updatedAt = null;

        #[Groups(['create'])]
        public ?string $createdByUser = null;

        #[Groups(['create'])]
        public ?string $updatedByUser = null;
    */
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public ?string $priority;

    #[Groups(['create'])]
    public ?string $sprintTemplate = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public ?string $status;

    #[Groups(['create'])]
    public ?string $comment = null;

    #[Groups(['create'])]
    public ?string $sprintDependency = null;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public ?string $projectInstance;
}
