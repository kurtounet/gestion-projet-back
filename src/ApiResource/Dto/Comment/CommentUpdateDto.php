<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Comment.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class CommentUpdateDto
{
    #[Groups(['update'])]
    public ?string $subject = null;

    #[Groups(['update'])]
    public ?string $content = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $task = null;
    #[Groups(['update'])]
    public ?string $user = null;
}
