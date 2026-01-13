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
use App\ApiResource\Dto\Context\ContextItemDto;
use App\ApiResource\Dto\Context\ContextCollectionItemDto;

use App\ApiResource\State\Context\ContextCollectionProvider;
use App\ApiResource\State\Context\ContextItemProvider;
use App\ApiResource\State\Context\ContextCreateProcessor;
use App\ApiResource\State\Context\ContextUpdateProcessor;
use App\ApiResource\State\Context\ContextDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Context',
    stateOptions: new Options(entityClass: Context::class),
    operations: [
        new GetCollection(
            uriTemplate: 'context',
            normalizationContext: ['groups' => ['Context:collection:read']],
            provider: ContextCollectionProvider::class,
            output: ContextCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'context/{id}',
            normalizationContext: ['groups' => ['Context:item:read']],
            provider: ContextItemProvider::class,
            output: ContextItemDto::class
        ),
        new Post(
            uriTemplate: 'context/{id}',
            denormalizationContext: ['groups' => ['Context:create']],
            processor: ContextCreateProcessor::class,
            input: ContextCreateDto::class,
            output: ContextItemDto::class
        ),
        new Patch(
            uriTemplate: 'context/{id}',
            denormalizationContext: ['groups' => ['Context:update']],
            processor: ContextUpdateProcessor::class,
            input: ContextUpdateDto::class,
            output: ContextItemDto::class
        ),
        new Delete(
            uriTemplate: 'context/{id}',
            processor: ContextDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: Context::class)]
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
