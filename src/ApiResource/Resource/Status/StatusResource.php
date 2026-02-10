<?php

namespace App\ApiResource\Resource\Status;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Status\StatusCollectionItemDto;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\Status\StatusItemDto;
use App\ApiResource\Dto\Status\StatusUpdateDto;
use App\ApiResource\State\Status\StatusCollectionProvider;
use App\ApiResource\State\Status\StatusCreateProcessor;
use App\ApiResource\State\Status\StatusDeleteProcessor;
use App\ApiResource\State\Status\StatusItemProvider;
use App\ApiResource\State\Status\StatusUpdateProcessor;
use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Status',
    stateOptions: new Options(entityClass: Status::class),
    operations: [
        new GetCollection(
            uriTemplate: 'statuses',
            normalizationContext: ['groups' => ['Status:collection:read']],
            provider: StatusCollectionProvider::class,
            output: StatusCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'statuses/{id}',
            normalizationContext: ['groups' => ['Status:item:read']],
            provider: StatusItemProvider::class,
            output: StatusItemDto::class
        ),
        new Post(
            uriTemplate: 'statuses',
            denormalizationContext: ['groups' => ['Status:create']],
            processor: StatusCreateProcessor::class,
            input: StatusCreateDto::class,
            output: StatusItemDto::class
        ),
        new Patch(
            uriTemplate: 'statuses/{id}',
            denormalizationContext: ['groups' => ['Status:update']],
            processor: StatusUpdateProcessor::class,
            input: StatusUpdateDto::class,
            output: StatusItemDto::class
        ),
        new Delete(
            uriTemplate: 'statuses/{id}',
            processor: StatusDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: Status::class)]
final class StatusResource
{
    public int $id;
    /*
        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public int $id;

        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public string $label;

        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public ?string $color;

        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public ?\DateTimeInterface $updatedAt;

        #[Groups(['Status:collection:read', 'Status:item:read'])]
        public ?string $context = null;

    */
}
