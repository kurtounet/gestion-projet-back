<?php

namespace App\ApiResource\Resource\Comment;

use App\Entity\Comment;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Comment\CommentCreateDto;
use App\ApiResource\Dto\Comment\CommentUpdateDto;
use App\ApiResource\Dto\Comment\CommentItemDto;
use App\ApiResource\Dto\Comment\CommentCollectionItemDto;

use App\ApiResource\State\Comment\CommentCollectionProvider;
use App\ApiResource\State\Comment\CommentItemProvider;
use App\ApiResource\State\Comment\CommentCreateProcessor;
use App\ApiResource\State\Comment\CommentUpdateProcessor;
use App\ApiResource\State\Comment\CommentDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Comment',
    stateOptions: new Options(entityClass: Comment::class),
    operations: [
        new GetCollection(
            uriTemplate: 'comments',
            normalizationContext: ['groups' => ['Comment:collection:read']],
            provider: CommentCollectionProvider::class,
            output: CommentCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'comments/{id}',
            normalizationContext: ['groups' => ['Comment:item:read']],
            provider: CommentItemProvider::class,
            output: CommentItemDto::class
        ),
        new Post(
            uriTemplate: 'comments',
            denormalizationContext: ['groups' => ['Comment:create']],
            processor: CommentCreateProcessor::class,
            input: CommentCreateDto::class,
            output: CommentItemDto::class
        ),
        new Patch(
            uriTemplate: 'comments/{id}',
            denormalizationContext: ['groups' => ['Comment:update']],
            processor: CommentUpdateProcessor::class,
            input: CommentUpdateDto::class,
            output: CommentItemDto::class
        ),
        new Delete(
            uriTemplate: 'comments/{id}',
            processor: CommentDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: Comment::class)]
final class CommentResource
{
    public int $id;
/*
    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public int $id;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public string $subject;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public string $content;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public ?string $task = null;

    #[Groups(['Comment:collection:read', 'Comment:item:read'])]
    public ?string $user = null;

*/
}
