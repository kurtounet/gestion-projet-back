<?php

namespace App\ApiResource\Resource\ContextStatus;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ContextStatus\ContextStatusCollectionItemDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusItemDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\State\ContextStatus\ContextStatusCollectionProvider;
use App\ApiResource\State\ContextStatus\ContextStatusCreateProcessor;
use App\ApiResource\State\ContextStatus\ContextStatusDeleteProcessor;
use App\ApiResource\State\ContextStatus\ContextStatusItemProvider;
use App\ApiResource\State\ContextStatus\ContextStatusUpdateProcessor;
use App\Entity\ContextStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ContextStatus',
    stateOptions: new Options(entityClass: ContextStatus::class),
    operations: [
        new GetCollection(
            uriTemplate: 'context_statuses',
            normalizationContext: ['groups' => ['ContextStatus:collection:read']],
            provider: ContextStatusCollectionProvider::class,
            output: ContextStatusCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'context_statuses/{id}',
            normalizationContext: ['groups' => ['ContextStatus:item:read']],
            provider: ContextStatusItemProvider::class,
            output: ContextStatusItemDto::class
        ),
        new Post(
            uriTemplate: 'context_statuses',
            denormalizationContext: ['groups' => ['ContextStatus:create']],
            processor: ContextStatusCreateProcessor::class,
            input: ContextStatusCreateDto::class,
            output: ContextStatusItemDto::class
        ),
        new Patch(
            uriTemplate: 'context_statuses/{id}',
            denormalizationContext: ['groups' => ['ContextStatus:update']],
            processor: ContextStatusUpdateProcessor::class,
            input: ContextStatusUpdateDto::class,
            output: ContextStatusItemDto::class
        ),
        new Delete(
            uriTemplate: 'context_statuses/{id}',
            processor: ContextStatusDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: ContextStatus::class)]
final class ContextStatusResource
{
    public int $id;
    /*
        #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
        public int $id;

        #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
        public ?\DateTimeInterface $updatedAt;

        #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
        public ?string $context = null;

        #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
        public ?string $status = null;

    */
}
