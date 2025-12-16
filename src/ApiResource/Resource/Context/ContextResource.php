<?php

namespace App\ApiResource\Resource\Context;

use App\Entity\Context;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Context\ContextCreateDto;
use App\ApiResource\Dto\Context\ContextUpdateDto;
use App\ApiResource\Dto\Context\ContextResponseDto;
use App\ApiResource\Dto\Context\ContextCollectionResponse;

use App\ApiResource\State\Context\ContextProvider;
use App\ApiResource\State\Context\ContextProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Context',
    stateOptions: new Options(entityClass: Context::class),
    operations: [
        new GetCollection(
            // security: "is_granted('CONTEXT_LIST', object)",
            // normalizationContext: ['groups' => ['Context:collection:read']],
            // provider: ContextProvider::class,
            // output: ContextCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('CONTEXT_VIEW', object)",
            // normalizationContext: ['groups' => ['Context:item:read']],
            // provider: ContextProvider::class,
            // output: ContextResponseDto::class
        ),
        new Post(
            // security: "is_granted('CONTEXT_CREATE', object)",
            // denormalizationContext: ['groups' => ['Context:create']],
            // processor: ContextProcessor::class,
            // input: ContextCreateDto::class
        ),
        new Patch(
            // security: "is_granted('CONTEXT_EDIT', object)",
            // denormalizationContext: ['groups' => ['Context:update']],
            // processor: ContextProcessor::class,
            // input:ContexteUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('CONTEXT_DELETE', object)",
            // processor: ContextProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Context.
 * Utilisé pour exposer Context.
 */
#[Map(source: Context::class)]
final class ContextResource
{
    #[Groups(['Context:item:read', 'Context:collection:read'])]
    public int $id;

    #[Groups(['Context:item:read', 'Context:collection:read'])]
    public string $contextLabel;

    #[Groups(['Context:item:read', 'Context:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Context:item:read', 'Context:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
