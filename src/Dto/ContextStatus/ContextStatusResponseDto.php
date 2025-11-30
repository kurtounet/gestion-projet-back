<?php

declare(strict_types=1);

namespace App\Dto\ContextStatus;

use DateTimeInterface;
final class ContextStatusResponseDto
{
    public function __construct(
        public int $id,

        public int $contextId,

        public string $statusId,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
