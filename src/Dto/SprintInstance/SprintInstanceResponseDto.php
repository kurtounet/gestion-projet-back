<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
final class SprintInstanceResponseDto
{
    public function __construct(
        public int $id,

        public string $name,

        public DateTimeInterface $startDate,

        public DateTimeInterface $endDate,

        public int $order,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
