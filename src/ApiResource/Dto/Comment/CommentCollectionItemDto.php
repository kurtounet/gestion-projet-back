<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Comment::class)]
final class CommentCollectionItemDto
{
    #[Groups(['Comment:collection:read'])]
    public int $id;

    #[Groups(['Comment:collection:read'])]
    public string $subject;

    #[Groups(['Comment:collection:read'])]
    public string $content;

    #[Groups(['Comment:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
