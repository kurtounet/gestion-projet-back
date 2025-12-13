<?php

namespace App\ApiResource\Dto\Comment;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Comment;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Comment.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Comment',
    stateOptions: new Options(entityClass: Comment::class),
)]
#[Map(source: Comment::class)]
final class CommentResponseDto
{
    #[Groups(['Comment:read'])]
    public int $id;

    #[Groups(['Comment:read'])]
    public string $subject;

    #[Groups(['Comment:read'])]
    public string $content;

    #[Groups(['Comment:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:read'])]
    public ?\DateTimeInterface $updatedAt;
}
