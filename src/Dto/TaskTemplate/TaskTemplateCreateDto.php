<?php

declare(strict_types=1);

namespace App\Dto\TaskTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskTemplateCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $sprintTemplateId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public int $parentTask,

        #[Assert\NotNull]
        public int $typeTaskId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
