<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
final class SprintInstanceResponseDto
{
    public function __construct(
        public int $id,

        public int $projectInstanceId,

        public int $priorityId,

        public int $sprintTemplateId,

        public int $sprintDependencyId,

        public string $name,

        public DateTimeInterface $startDate,

        public DateTimeInterface $endDate,

        public int $statusId,

        public int $order,

        public int $commentId,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
