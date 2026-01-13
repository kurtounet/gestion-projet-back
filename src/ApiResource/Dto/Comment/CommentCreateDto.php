<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Comment.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Comment::class)]
final class CommentCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Comment:create'])]
    public string $subject;

    #[Assert\NotBlank]
    #[Groups(['Comment:create'])]
    public string $content;

    #[Assert\NotBlank]
    #[Groups(['Comment:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:create'])]
    public ?\DateTimeInterface $updatedAt;



    #[Groups(['Comment:create'])]
    public ?string $task;
    #[Groups(['Comment:create'])]
    public ?string $user;
}
