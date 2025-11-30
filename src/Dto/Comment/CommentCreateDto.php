<?php

declare(strict_types=1);

namespace App\Dto\Comment;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CommentCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $taskId,

        #[Assert\NotNull]
        public int $userId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $subject,

        #[Assert\NotBlank]
        public string $content,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
