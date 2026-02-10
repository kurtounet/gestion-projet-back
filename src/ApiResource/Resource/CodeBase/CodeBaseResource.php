<?php

namespace App\ApiResource\Resource\CodeBase;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\CodeBase\CodeBaseCollectionItemDto;
use App\ApiResource\Dto\CodeBase\CodeBaseCreateDto;
use App\ApiResource\Dto\CodeBase\CodeBaseItemDto;
use App\ApiResource\Dto\CodeBase\CodeBaseUpdateDto;
use App\ApiResource\State\CodeBase\CodeBaseCollectionProvider;
use App\ApiResource\State\CodeBase\CodeBaseCreateProcessor;
use App\ApiResource\State\CodeBase\CodeBaseDeleteProcessor;
use App\ApiResource\State\CodeBase\CodeBaseItemProvider;
use App\ApiResource\State\CodeBase\CodeBaseUpdateProcessor;
use App\Entity\CodeBase;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'CodeBase',
    stateOptions: new Options(entityClass: CodeBase::class),
    operations: [
        new GetCollection(
            uriTemplate: 'code_bases',
            normalizationContext: ['groups' => ['CodeBase:collection:read']],
            provider: CodeBaseCollectionProvider::class,
            output: CodeBaseCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'code_bases/{id}',
            normalizationContext: ['groups' => ['CodeBase:item:read']],
            provider: CodeBaseItemProvider::class,
            output: CodeBaseItemDto::class
        ),
        new Post(
            uriTemplate: 'code_bases',
            denormalizationContext: ['groups' => ['CodeBase:create']],
            processor: CodeBaseCreateProcessor::class,
            input: CodeBaseCreateDto::class,
            output: CodeBaseItemDto::class
        ),
        new Patch(
            uriTemplate: 'code_bases/{id}',
            denormalizationContext: ['groups' => ['CodeBase:update']],
            processor: CodeBaseUpdateProcessor::class,
            input: CodeBaseUpdateDto::class,
            output: CodeBaseItemDto::class
        ),
        new Delete(
            uriTemplate: 'code_bases/{id}',
            processor: CodeBaseDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: CodeBase::class)]
final class CodeBaseResource
{
    public int $id;
    /*
        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public int $id;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public string $label;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public string $code;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public string $pathFile;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public string $feature;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['CodeBase:collection:read', 'CodeBase:item:read'])]
        public ?\DateTimeInterface $updatedAt;


    */
}
