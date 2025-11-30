<?php

declare(strict_types=1);

namespace App\Dto\Feature;

use DateTimeInterface;
final class FeatureResponseDto
{
    public function __construct(
        public int $id,

        public string $label,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
