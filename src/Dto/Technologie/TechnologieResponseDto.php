<?php

declare(strict_types=1);

namespace App\Dto\Technologie;

use DateTimeInterface;
final class TechnologieResponseDto
{
    public function __construct(
        public int $id,

        public string $label,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
