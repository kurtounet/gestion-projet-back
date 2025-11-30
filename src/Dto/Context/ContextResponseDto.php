<?php

declare(strict_types=1);

namespace App\Dto\Context;

use DateTimeInterface;
final class ContextResponseDto
{
    public function __construct(
        public int $id,

        public string $contextLabel,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
