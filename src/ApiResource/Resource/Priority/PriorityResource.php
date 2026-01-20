<?php

namespace App\ApiResource\Resource\Priority;

use App\Entity\Priority;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Priority\PriorityUpdateDto;
use App\ApiResource\Dto\Priority\PriorityItemDto;
use App\ApiResource\Dto\Priority\PriorityCollectionItemDto;

use App\ApiResource\State\Priority\PriorityCollectionProvider;
use App\ApiResource\State\Priority\PriorityItemProvider;
use App\ApiResource\State\Priority\PriorityCreateProcessor;
use App\ApiResource\State\Priority\PriorityUpdateProcessor;
use App\ApiResource\State\Priority\PriorityDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Priority',
    stateOptions: new Options(entityClass: Priority::class),
    operations: [
        new GetCollection(
            uriTemplate: 'priorities',
            normalizationContext: ['groups' => ['Priority:collection:read']],
            provider: PriorityCollectionProvider::class,
            output: PriorityCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'priorities/{id}',
            normalizationContext: ['groups' => ['Priority:item:read']],
            provider: PriorityItemProvider::class,
            output: PriorityItemDto::class
        ),
        new Post(
            uriTemplate: 'priorities',
            denormalizationContext: ['groups' => ['Priority:create']],
            processor: PriorityCreateProcessor::class,
            input: PriorityCreateDto::class,
            output: PriorityItemDto::class
        ),
        new Patch(
            uriTemplate: 'priorities/{id}',
            denormalizationContext: ['groups' => ['Priority:update']],
            processor: PriorityUpdateProcessor::class,
            input: PriorityUpdateDto::class,
            output: PriorityItemDto::class
        ),
        new Delete(
            uriTemplate: 'priorities/{id}',
            processor: PriorityDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: Priority::class)]
final class PriorityResource
{
    public int $id;
/*
    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public int $id;

    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public string $label;

    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public ?string $color;

    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public int $priorityNumber;

    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:collection:read', 'Priority:item:read'])]
    public ?\DateTimeInterface $updatedAt;


*/
}
