<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
final class PriorityResponseDto
{
    public function __construct(
        public int $id,

        public int $priorityId,

        public string $priorityLabel,

        public int $priorityNumber,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
