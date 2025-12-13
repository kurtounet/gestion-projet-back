<?php

namespace App\ApiResource\Resource\Priority;

use App\Entity\Priority;

;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Priority\PriorityUpdateDto;
use App\ApiResource\Dto\Priority\PriorityResponseDto;
use App\ApiResource\Dto\Priority\PriorityCollectionResponse;

use App\ApiResource\State\Priority\PriorityProvider;
use App\ApiResource\State\Priority\PriorityProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Priority',
    stateOptions: new Options(entityClass: Priority::class),
    operations: [
        new GetCollection(
            // security: "is_granted('PRIORITY_LIST', object)",
            // normalizationContext: ['groups' => ['Priority:collection:read']],
            // provider: PriorityProvider::class,
            // output: PriorityCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('PRIORITY_VIEW', object)",
            // normalizationContext: ['groups' => ['Priority:item:read']],
            // provider: PriorityProvider::class,
            // output: PriorityResponseDto::class
        ),
        new Post(
            // security: "is_granted('PRIORITY_CREATE', object)",
            // denormalizationContext: ['groups' => ['Priority:create']],
            // processor: PriorityProcessor::class,
            // input: PriorityCreateDto::class
        ),
        new Patch(
            // security: "is_granted('PRIORITY_EDIT', object)",
            // denormalizationContext: ['groups' => ['Priority:update']],
            // processor: PriorityProcessor::class,
            // input:PriorityeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('PRIORITY_DELETE', object)",
            // processor: PriorityProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Priority.
 * Utilisé pour exposer Priority.
 */
#[Map(source: Priority::class)]
final class PriorityResource
{
    #[Groups(['Priority:read'])]
    public int $id;

    #[Groups(['Priority:read'])]
    public string $label;

    #[Groups(['Priority:read'])]
    public ?string $color;

    #[Groups(['Priority:read'])]
    public int $priorityNumber;

    #[Groups(['Priority:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Priority:read'])]
    public ?\DateTimeInterface $updatedAt;

}
