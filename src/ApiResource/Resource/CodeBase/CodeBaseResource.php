<?php

namespace App\ApiResource\Resource\CodeBase;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\CodeBase\CodeBaseCreateDto;
use App\ApiResource\Dto\CodeBase\CodeBaseUpdateDto;
use App\ApiResource\State\CodeBase\CodeBaseCollectionProvider;
use App\ApiResource\State\CodeBase\CodeBaseCreateProcessor;
use App\ApiResource\State\CodeBase\CodeBaseDeleteProcessor;
use App\ApiResource\State\CodeBase\CodeBaseItemProvider;
use App\ApiResource\State\CodeBase\CodeBaseUpdateProcessor;
use App\Entity\CodeBase;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'CodeBase',
    stateOptions: new Options(entityClass: CodeBase::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: CodeBaseCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: CodeBaseItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: CodeBaseCreateProcessor::class,
            input: CodeBaseCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: CodeBaseUpdateProcessor::class,
            input: CodeBaseUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: CodeBaseDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class CodeBaseResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $label;

    #[Groups(['collection:read', 'item:read'])]
    public string $code;

    #[Groups(['collection:read', 'item:read'])]
    public string $pathFile;

    #[Groups(['collection:read', 'item:read'])]
    public string $feature;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
