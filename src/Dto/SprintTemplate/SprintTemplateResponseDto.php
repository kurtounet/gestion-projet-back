<?php

declare(strict_types=1);

namespace App\Dto\SprintTemplate;

use DateTimeInterface;
final class SprintTemplateResponseDto
{
    public function __construct(
        public int $id,

        public string $name,

        public string $description,

        public int $duration,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
