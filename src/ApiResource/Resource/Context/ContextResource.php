<?php

namespace App\ApiResource\Resource\Context;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Context\ContextCollectionItemDto;
use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextItemDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;
use App\ApiResource\State\Context\ContextCollectionProvider;
use App\ApiResource\State\Context\ContextCreateProcessor;
use App\ApiResource\State\Context\ContextDeleteProcessor;
use App\ApiResource\State\Context\ContextItemProvider;
use App\ApiResource\State\Context\ContextUpdateProcessor;
use App\Entity\Context;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Context',
    stateOptions: new Options(entityClass: Context::class),
    operations: [
        new GetCollection(
            uriTemplate: 'contexts',
            normalizationContext: ['groups' => ['Context:collection:read']],
            provider: ContextCollectionProvider::class,
            output: ContextCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'contexts/{id}',
            normalizationContext: ['groups' => ['Context:item:read']],
            provider: ContextItemProvider::class,
            output: ContextItemDto::class
        ),
        new Post(
            uriTemplate: 'contexts',
            denormalizationContext: ['groups' => ['Context:create']],
            processor: ContextCreateProcessor::class,
            input: ContextCreateDto::class,
            output: ContextItemDto::class
        ),
        new Patch(
            uriTemplate: 'contexts/{id}',
            denormalizationContext: ['groups' => ['Context:update']],
            processor: ContextUpdateProcessor::class,
            input: ContextUpdateDto::class,
            output: ContextItemDto::class
        ),
        new Delete(
            uriTemplate: 'contexts/{id}',
            processor: ContextDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: Context::class)]
final class ContextResource
{
    public int $id;
    /*
        #[Groups(['Context:collection:read', 'Context:item:read'])]
        public int $id;

        #[Groups(['Context:collection:read', 'Context:item:read'])]
        public string $contextLabel;

        #[Groups(['Context:collection:read', 'Context:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['Context:collection:read', 'Context:item:read'])]
        public ?\DateTimeInterface $updatedAt;


    */
}
