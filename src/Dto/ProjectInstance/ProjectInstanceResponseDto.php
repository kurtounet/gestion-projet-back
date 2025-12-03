<?php

declare(strict_types=1);

namespace App\Dto\ProjectInstance;

use DateTimeInterface;
final class ProjectInstanceResponseDto
{
    public function __construct(
        public int $id,

        public string $name,

        public string $description,

        public DateTimeInterface $startDate,

        public DateTimeInterface $endDate,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
