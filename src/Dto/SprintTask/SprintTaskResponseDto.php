<?php

declare(strict_types=1);

namespace App\Dto\SprintTask;

use DateTimeInterface;
final class SprintTaskResponseDto
{
    public function __construct(
        public int $id,

        public int $taskOrder,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
