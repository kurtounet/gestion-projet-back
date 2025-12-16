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
use App\ApiResource\Dto\Feature\FeatureResponseDto;
use App\ApiResource\Dto\Feature\FeatureCollectionResponse;

use App\ApiResource\State\Feature\FeatureProvider;
use App\ApiResource\State\Feature\FeatureProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Feature',
    stateOptions: new Options(entityClass: Feature::class),
    operations: [
        new GetCollection(
            // security: "is_granted('FEATURE_LIST', object)",
            // normalizationContext: ['groups' => ['Feature:collection:read']],
            // provider: FeatureProvider::class,
            // output: FeatureCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('FEATURE_VIEW', object)",
            // normalizationContext: ['groups' => ['Feature:item:read']],
            // provider: FeatureProvider::class,
            // output: FeatureResponseDto::class
        ),
        new Post(
            // security: "is_granted('FEATURE_CREATE', object)",
            // denormalizationContext: ['groups' => ['Feature:create']],
            // processor: FeatureProcessor::class,
            // input: FeatureCreateDto::class
        ),
        new Patch(
            // security: "is_granted('FEATURE_EDIT', object)",
            // denormalizationContext: ['groups' => ['Feature:update']],
            // processor: FeatureProcessor::class,
            // input:FeatureeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('FEATURE_DELETE', object)",
            // processor: FeatureProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Feature.
 * Utilisé pour exposer Feature.
 */
#[Map(source: Feature::class)]
final class FeatureResource
{
    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public int $id;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public string $label;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Feature:collection:read', 'Feature:item:read'])]
    public ?\DateTimeInterface $updatedAt;
}
