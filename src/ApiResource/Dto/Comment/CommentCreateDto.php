<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Comment.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class CommentCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $subject;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $content;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public ?string $task = null;
    #[Groups(['create'])]
    public ?string $user = null;
}
