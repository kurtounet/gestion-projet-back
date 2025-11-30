<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskInstanceUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $userId = null,

        public ?int $taskTemplateId = null,

        public ?int $sprintInstanceId = null,

        public ?int $priorityId = null,

        public ?int $statusId = null,

        public ?int $typeTaskId = null,

        #[Assert\Length(max: 255)]
        public ?string $name = null,

        public ?string $description = null,

        public ?DateTimeInterface $startDate = null,

        public ?DateTimeInterface $dueDate = null,

        public ?int $order = null,

        public ?int $parentTask = null,

        public ?int $dependencyId = null,

        public ?int $commentId = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
