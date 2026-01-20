<?php

namespace App\ApiResource\Dto\Comment;

use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Comment::class)]
final class CommentRelationDto
{
    #[Groups(['Comment:relation:read'])]
    public int $id;
}
