<?php

declare(strict_types=1);

namespace App\Dto\Comment;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CommentUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $subject = null,

        public ?string $content = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
