<?php

declare(strict_types=1);

namespace App\Dto\CodeBase;

use DateTimeInterface;
final class CodeBaseResponseDto
{
    public function __construct(
        public int $id,

        public string $label,

        public string $code,

        public string $pathFile,

        public string $feature,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
