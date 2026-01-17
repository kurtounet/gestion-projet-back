<?php

namespace App\ApiResource\Resource\Feature;

use App\Entity\Feature;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Feature\FeatureCreateDto;
use App\ApiResource\Dto\Feature\FeatureUpdateDto;
use App\ApiResource\Dto\Feature\FeatureItemDto;
use App\ApiResource\Dto\Feature\FeatureCollectionItemDto;

use App\ApiResource\State\Feature\FeatureCollectionProvider;
use App\ApiResource\State\Feature\FeatureItemProvider;
use App\ApiResource\State\Feature\FeatureCreateProcessor;
use App\ApiResource\State\Feature\FeatureUpdateProcessor;
use App\ApiResource\State\Feature\FeatureDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Feature',
    stateOptions: new Options(entityClass: Feature::class),
    operations: [
        new GetCollection(
            uriTemplate: 'feature',
            normalizationContext: ['groups' => ['Feature:collection:read']],
            provider: FeatureCollectionProvider::class,
            output: FeatureCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'feature/{id}',
            normalizationContext: ['groups' => ['Feature:item:read']],
            provider: FeatureItemProvider::class,
            output: FeatureItemDto::class
        ),
        new Post(
            uriTemplate: 'feature/{id}',
            denormalizationContext: ['groups' => ['Feature:create']],
            processor: FeatureCreateProcessor::class,
            input: FeatureCreateDto::class,
            output: FeatureItemDto::class
        ),
        new Patch(
            uriTemplate: 'feature/{id}',
            denormalizationContext: ['groups' => ['Feature:update']],
            processor: FeatureUpdateProcessor::class,
            input: FeatureUpdateDto::class,
            output: FeatureItemDto::class
        ),
        new Delete(
            uriTemplate: 'feature/{id}',
            processor: FeatureDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: Feature::class)]
final class FeatureResource
{
    public int $id;
/*
    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public int $id;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public string $label;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public ?\DateTimeInterface $updatedAt;


*/
}
