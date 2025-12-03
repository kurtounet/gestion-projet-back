<?php

declare(strict_types=1);

namespace App\Dto\Comment;

use DateTimeInterface;
final class CommentResponseDto
{
    public function __construct(
        public int $id,

        public string $subject,

        public string $content,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
