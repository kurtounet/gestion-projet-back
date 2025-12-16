<?php

namespace App\ApiResource\Resource\Comment;

use App\Entity\Comment;

use App\Entity\TaskInstance;
use App\Entity\User;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Dto\Comment\CommentUpdateDto;
use App\ApiResource\Dto\Comment\CommentResponseDto;
use App\ApiResource\Dto\Comment\CommentCollectionResponse;

use App\ApiResource\State\Comment\CommentProvider;
use App\ApiResource\State\Comment\CommentProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Comment',
    stateOptions: new Options(entityClass: Comment::class),
    operations: [
        new GetCollection(
            // security: "is_granted('COMMENT_LIST', object)",
            // normalizationContext: ['groups' => ['Comment:collection:read']],
            // provider: CommentProvider::class,
            // output: CommentCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('COMMENT_VIEW', object)",
            // normalizationContext: ['groups' => ['Comment:item:read']],
            // provider: CommentProvider::class,
            // output: CommentResponseDto::class
        ),
        new Post(
            // security: "is_granted('COMMENT_CREATE', object)",
            // denormalizationContext: ['groups' => ['Comment:create']],
            // processor: CommentProcessor::class,
            // input: CommentCreateDto::class
        ),
        new Patch(
            // security: "is_granted('COMMENT_EDIT', object)",
            // denormalizationContext: ['groups' => ['Comment:update']],
            // processor: CommentProcessor::class,
            // input:CommenteUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('COMMENT_DELETE', object)",
            // processor: CommentProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Comment.
 * Utilisé pour exposer Comment.
 */
#[Map(source: Comment::class)]
final class CommentResource
{
    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public int $id;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public string $subject;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public string $content;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public ?string $task;

    #[Groups(['Comment:item:read', 'Comment:collection:read'])]
    public ?User $user;
}
