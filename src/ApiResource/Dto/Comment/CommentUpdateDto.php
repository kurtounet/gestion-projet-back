<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de mise à jour partielle pour Comment.
 * Utilisé typiquement pour PATCH/PUT.
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
}
