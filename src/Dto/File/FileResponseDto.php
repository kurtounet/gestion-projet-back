<?php

declare(strict_types=1);

namespace App\Dto\File;

use DateTimeInterface;
final class FileResponseDto
{
    public function __construct(
        public int $id,

        public string $path,

        public string $keyWord,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
