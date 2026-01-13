<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Comment.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Comment::class)]
final class CommentUpdateDto
{
    #[Groups(['Comment:update'])]
    public ?string $subject;

    #[Groups(['Comment:update'])]
    public ?string $content;

    #[Groups(['Comment:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Comment:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Comment:update'])]
    public ?string $task;
    #[Groups(['Comment:update'])]
    public ?string $user;
}
