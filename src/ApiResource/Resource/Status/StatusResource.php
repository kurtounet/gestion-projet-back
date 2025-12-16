<?php

namespace App\ApiResource\Resource\Status;

use App\Entity\Status;

use App\Entity\Context;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\Status\StatusUpdateDto;
use App\ApiResource\Dto\Status\StatusResponseDto;
use App\ApiResource\Dto\Status\StatusCollectionResponse;

use App\ApiResource\State\Status\StatusProvider;
use App\ApiResource\State\Status\StatusProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Status',
    uriTemplate: '/statuses/{id}',
    stateOptions: new Options(entityClass: Status::class),
    operations: [
        new GetCollection(
            uriTemplate: '/statuses',
            // security: "is_granted('STATUS_LIST', object)",
            normalizationContext: ['groups' => ['status:list:read']],
            // provider: StatusProvider::class,
            // output: StatusCollectionResponse::class
        ),
        new Get(
            uriTemplate: '/statuses/{id}',
            // security: "is_granted('STATUS_VIEW', object)",
            normalizationContext: ['groups' => ['PI:item:read', 'status:item:read']],
            // provider: StatusProvider::class,
            // output: StatusResponseDto::class
        ),
        new Post(
            // security: "is_granted('STATUS_CREATE', object)",
            // denormalizationContext: ['groups' => ['Status:create']],
            // processor: StatusProcessor::class,
            // input: StatusCreateDto::class
        ),
        new Patch(
            // security: "is_granted('STATUS_EDIT', object)",
            // denormalizationContext: ['groups' => ['Status:update']],
            // processor: StatusProcessor::class,
            // input:StatuseUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('STATUS_DELETE', object)",
            // processor: StatusProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Status.
 * Utilisé pour exposer Status.
 */
#[Map(source: Status::class)]
final class StatusResource
{
    #[Groups(['PI:item:read', 'status:list:read', 'status:item:read'])]
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Groups(['status:list:read', 'status:item:read'])]
    public string $label;

    #[Groups(['status:list:read', 'status:item:read'])]
    public ?string $color;

    #[Groups(['status:list:read', 'status:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['status:list:read', 'status:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    // #[Groups(['status:list:read', 'status:item:read'])]
    // public ?Context $context;
}
