<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
final class TaskInstanceResponseDto
{
    public function __construct(
        public int $id,

        public int $userId,

        public int $taskTemplateId,

        public int $sprintInstanceId,

        public int $priorityId,

        public int $statusId,

        public int $typeTaskId,

        public string $name,

        public string $description,

        public DateTimeInterface $startDate,

        public DateTimeInterface $dueDate,

        public int $order,

        public int $parentTask,

        public int $dependencyId,

        public int $commentId,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
