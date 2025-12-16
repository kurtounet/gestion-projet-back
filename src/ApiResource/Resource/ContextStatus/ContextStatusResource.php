<?php

namespace App\ApiResource\Resource\ContextStatus;

use App\Entity\ContextStatus;

use App\Entity\Context;
use App\Entity\Status;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ContextStatus\ContextStatusCreateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusUpdateDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusResponseDto;
use App\ApiResource\Dto\ContextStatus\ContextStatusCollectionResponse;

use App\ApiResource\State\ContextStatus\ContextStatusProvider;
use App\ApiResource\State\ContextStatus\ContextStatusProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ContextStatus',
    stateOptions: new Options(entityClass: ContextStatus::class),
    operations: [
        new GetCollection(
            // security: "is_granted('CONTEXT_STATUS_LIST', object)",
            // normalizationContext: ['groups' => ['ContextStatus:collection:read']],
            // provider: ContextStatusProvider::class,
            // output: ContextStatusCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('CONTEXT_STATUS_VIEW', object)",
            // normalizationContext: ['groups' => ['ContextStatus:item:read']],
            // provider: ContextStatusProvider::class,
            // output: ContextStatusResponseDto::class
        ),
        new Post(
            // security: "is_granted('CONTEXT_STATUS_CREATE', object)",
            // denormalizationContext: ['groups' => ['ContextStatus:create']],
            // processor: ContextStatusProcessor::class,
            // input: ContextStatusCreateDto::class
        ),
        new Patch(
            // security: "is_granted('CONTEXT_STATUS_EDIT', object)",
            // denormalizationContext: ['groups' => ['ContextStatus:update']],
            // processor: ContextStatusProcessor::class,
            // input:ContextStatuseUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('CONTEXT_STATUS_DELETE', object)",
            // processor: ContextStatusProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour ContextStatus.
 * Utilisé pour exposer ContextStatus.
 */
#[Map(source: ContextStatus::class)]
final class ContextStatusResource
{
    #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
    public int $id;

    #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
    public ?\DateTimeInterface $updatedAt;
    /*
    #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
    public ?Context $context;

    #[Groups(['ContextStatus:collection:read', 'ContextStatus:item:read'])]
    public ?Status $status;
    */
}
