<?php

namespace App\ApiResource\Resource\Technology;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Technology\TechnologyCollectionItemDto;
use App\ApiResource\Dto\Technology\TechnologyCreateDto;
use App\ApiResource\Dto\Technology\TechnologyItemDto;
use App\ApiResource\Dto\Technology\TechnologyUpdateDto;
use App\ApiResource\State\Technology\TechnologyCollectionProvider;
use App\ApiResource\State\Technology\TechnologyCreateProcessor;
use App\ApiResource\State\Technology\TechnologyDeleteProcessor;
use App\ApiResource\State\Technology\TechnologyItemProvider;
use App\ApiResource\State\Technology\TechnologyUpdateProcessor;
use App\Entity\Technology;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Technology',
    stateOptions: new Options(entityClass: Technology::class),
    operations: [
        new GetCollection(
            uriTemplate: 'technologies',
            normalizationContext: ['groups' => ['Technology:collection:read']],
            provider: TechnologyCollectionProvider::class,
            output: TechnologyCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'technologies/{id}',
            normalizationContext: ['groups' => ['Technology:item:read']],
            provider: TechnologyItemProvider::class,
            output: TechnologyItemDto::class
        ),
        new Post(
            uriTemplate: 'technologies',
            denormalizationContext: ['groups' => ['Technology:create']],
            processor: TechnologyCreateProcessor::class,
            input: TechnologyCreateDto::class,
            output: TechnologyItemDto::class
        ),
        new Patch(
            uriTemplate: 'technologies/{id}',
            denormalizationContext: ['groups' => ['Technology:update']],
            processor: TechnologyUpdateProcessor::class,
            input: TechnologyUpdateDto::class,
            output: TechnologyItemDto::class
        ),
        new Delete(
            uriTemplate: 'technologies/{id}',
            processor: TechnologyDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: Technology::class)]
final class TechnologyResource
{
    public int $id;
    /*
        #[Groups(['Technology:collection:read', 'Technology:item:read'])]
        public int $id;

        #[Groups(['Technology:collection:read', 'Technology:item:read'])]
        public string $label;

        #[Groups(['Technology:collection:read', 'Technology:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['Technology:collection:read', 'Technology:item:read'])]
        public ?\DateTimeInterface $updatedAt;

        #[Groups(['Technology:collection:read', 'Technology:item:read'])]
        public iterable $framework = [];

    */
}
