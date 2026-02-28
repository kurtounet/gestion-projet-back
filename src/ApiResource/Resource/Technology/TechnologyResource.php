<?php

namespace App\ApiResource\Resource\Technology;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Technology\TechnologyCreateDto;
use App\ApiResource\Dto\Technology\TechnologyUpdateDto;
use App\ApiResource\State\Technology\TechnologyCollectionProvider;
use App\ApiResource\State\Technology\TechnologyCreateProcessor;
use App\ApiResource\State\Technology\TechnologyDeleteProcessor;
use App\ApiResource\State\Technology\TechnologyItemProvider;
use App\ApiResource\State\Technology\TechnologyUpdateProcessor;
use App\Entity\Technology;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Technology',
    stateOptions: new Options(entityClass: Technology::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: TechnologyCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: TechnologyItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: TechnologyCreateProcessor::class,
            input: TechnologyCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: TechnologyUpdateProcessor::class,
            input: TechnologyUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: TechnologyDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class TechnologyResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $label;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public iterable $framework = [];


}
