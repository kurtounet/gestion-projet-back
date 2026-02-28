<?php

namespace App\ApiResource\Resource\ContextStatus;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\State\ContextStatus\ContextStatusCollectionProvider;
use App\ApiResource\State\ContextStatus\ContextStatusCreateProcessor;
use App\ApiResource\State\ContextStatus\ContextStatusDeleteProcessor;
use App\ApiResource\State\ContextStatus\ContextStatusItemProvider;
use App\ApiResource\State\ContextStatus\ContextStatusUpdateProcessor;
use App\Entity\ContextStatus;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ContextStatus',
    stateOptions: new Options(entityClass: ContextStatus::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ContextStatusCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ContextStatusItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ContextStatusCreateProcessor::class,
            input: ContextStatusCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ContextStatusUpdateProcessor::class,
            input: ContextStatusUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ContextStatusDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ContextStatusResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $context = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $status = null;


}
