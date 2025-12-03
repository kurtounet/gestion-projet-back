<?php

declare(strict_types=1);

namespace App\Dto\TaskTemplate;

use DateTimeInterface;
final class TaskTemplateResponseDto
{
    public function __construct(
        public int $id,

        public string $name,

        public string $description,

        public int $parentTask,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
