<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
final class TaskInstanceResponseDto
{
    public function __construct(
        public int $id,

        public string $name,

        public string $description,

        public DateTimeInterface $startDate,

        public DateTimeInterface $dueDate,

        public int $order,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
