<?php

namespace App\ApiResource\Resource\Feature;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Feature\FeatureCreateDto;
use App\ApiResource\Dto\Feature\FeatureUpdateDto;
use App\ApiResource\State\Feature\FeatureCollectionProvider;
use App\ApiResource\State\Feature\FeatureCreateProcessor;
use App\ApiResource\State\Feature\FeatureDeleteProcessor;
use App\ApiResource\State\Feature\FeatureItemProvider;
use App\ApiResource\State\Feature\FeatureUpdateProcessor;
use App\Entity\Feature;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Feature',
    stateOptions: new Options(entityClass: Feature::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: FeatureCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: FeatureItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: FeatureCreateProcessor::class,
            input: FeatureCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: FeatureUpdateProcessor::class,
            input: FeatureUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: FeatureDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class FeatureResource
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



}
