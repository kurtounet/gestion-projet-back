<?php

namespace App\ApiResource\Resource\Context;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;
use App\ApiResource\State\Context\ContextCollectionProvider;
use App\ApiResource\State\Context\ContextCreateProcessor;
use App\ApiResource\State\Context\ContextDeleteProcessor;
use App\ApiResource\State\Context\ContextItemProvider;
use App\ApiResource\State\Context\ContextUpdateProcessor;
use App\Entity\Context;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Context',
    stateOptions: new Options(entityClass: Context::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ContextCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ContextItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ContextCreateProcessor::class,
            input: ContextCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ContextUpdateProcessor::class,
            input: ContextUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ContextDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ContextResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $contextLabel;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
