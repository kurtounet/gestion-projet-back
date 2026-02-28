<?php

namespace App\ApiResource\Resource\Comment;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Dto\Comment\CommentUpdateDto;
use App\ApiResource\State\Comment\CommentCollectionProvider;
use App\ApiResource\State\Comment\CommentCreateProcessor;
use App\ApiResource\State\Comment\CommentDeleteProcessor;
use App\ApiResource\State\Comment\CommentItemProvider;
use App\ApiResource\State\Comment\CommentUpdateProcessor;
use App\Entity\Comment;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Comment',
    stateOptions: new Options(entityClass: Comment::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: CommentCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: CommentItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: CommentCreateProcessor::class,
            input: CommentCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: CommentUpdateProcessor::class,
            input: CommentUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: CommentDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class CommentResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $subject;

    #[Groups(['collection:read', 'item:read'])]
    public string $content;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $task = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $user = null;


}
