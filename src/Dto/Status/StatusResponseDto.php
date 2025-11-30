<?php

declare(strict_types=1);

namespace App\Dto\Status;

use DateTimeInterface;
final class StatusResponseDto
{
    public function __construct(
        public int $id,

        public int $statusId,

        public string $statusName,

        public int $statusContext,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
