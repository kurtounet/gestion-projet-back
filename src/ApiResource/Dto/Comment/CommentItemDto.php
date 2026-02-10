<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

// #[Map(source: Comment::class)]
final class CommentItemDto
{
    #[Groups(['Comment:item:read'])]
    public int $id;

    #[Groups(['Comment:item:read'])]
    public string $subject;

    #[Groups(['Comment:item:read'])]
    public string $content;

    #[Groups(['Comment:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Comment:item:read'])]
    public ?string $task = null;

    #[Groups(['Comment:item:read'])]
    public ?string $user = null;
}
