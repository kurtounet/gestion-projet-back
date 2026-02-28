<?php

namespace App\ApiResource\Resource\Status;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\Status\StatusUpdateDto;
use App\ApiResource\State\Status\StatusCollectionProvider;
use App\ApiResource\State\Status\StatusCreateProcessor;
use App\ApiResource\State\Status\StatusDeleteProcessor;
use App\ApiResource\State\Status\StatusItemProvider;
use App\ApiResource\State\Status\StatusUpdateProcessor;
use App\Entity\Status;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Status',
    stateOptions: new Options(entityClass: Status::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: StatusCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: StatusItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: StatusCreateProcessor::class,
            input: StatusCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: StatusUpdateProcessor::class,
            input: StatusUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: StatusDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class StatusResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $label;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $color = null;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $context = null;


}
