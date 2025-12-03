<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplate;

use DateTimeInterface;
final class ProjectTemplateResponseDto
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
