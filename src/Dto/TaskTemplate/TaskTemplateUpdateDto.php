<?php

declare(strict_types=1);

namespace App\Dto\TaskTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskTemplateUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $sprintTemplateId = null,

        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $name = null,

        public ?string $description = null,

        public ?int $parentTask = null,

        public ?int $typeTaskId = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
