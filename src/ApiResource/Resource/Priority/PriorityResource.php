<?php

namespace App\ApiResource\Resource\Priority;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Priority\PriorityUpdateDto;
use App\ApiResource\State\Priority\PriorityCollectionProvider;
use App\ApiResource\State\Priority\PriorityCreateProcessor;
use App\ApiResource\State\Priority\PriorityDeleteProcessor;
use App\ApiResource\State\Priority\PriorityItemProvider;
use App\ApiResource\State\Priority\PriorityUpdateProcessor;
use App\Entity\Priority;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Priority',
    stateOptions: new Options(entityClass: Priority::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: PriorityCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: PriorityItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: PriorityCreateProcessor::class,
            input: PriorityCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: PriorityUpdateProcessor::class,
            input: PriorityUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: PriorityDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class PriorityResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $label;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $color = null;

    #[Groups(['collection:read', 'item:read'])]
    public int $priorityNumber;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
