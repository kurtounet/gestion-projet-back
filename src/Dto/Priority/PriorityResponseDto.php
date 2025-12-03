<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
final class PriorityResponseDto
{
    public function __construct(
        public int $id,

        public string $label,

        public int $priorityNumber,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
