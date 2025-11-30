<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskInstanceCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $userId,

        #[Assert\NotNull]
        public int $taskTemplateId,

        #[Assert\NotNull]
        public int $sprintInstanceId,

        #[Assert\NotNull]
        public int $priorityId,

        #[Assert\NotNull]
        public int $statusId,

        #[Assert\NotNull]
        public int $typeTaskId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public DateTimeInterface $startDate,

        #[Assert\NotNull]
        public DateTimeInterface $dueDate,

        #[Assert\NotNull]
        public int $order,

        #[Assert\NotNull]
        public int $parentTask,

        #[Assert\NotNull]
        public int $dependencyId,

        #[Assert\NotNull]
        public int $commentId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
