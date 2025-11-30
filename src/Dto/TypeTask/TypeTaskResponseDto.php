<?php

declare(strict_types=1);

namespace App\Dto\TypeTask;

use DateTimeInterface;
final class TypeTaskResponseDto
{
    public function __construct(
        public int $id,

        public int $codeId,

        public string $name,

        public string $pathFileScript,

        public string $description,

        public bool $automatique,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
