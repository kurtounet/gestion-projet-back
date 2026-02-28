<?php

namespace App\ApiResource\Resource\SprintTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateCreateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateUpdateDto;
use App\ApiResource\State\SprintTemplate\SprintTemplateCollectionProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateCreateProcessor;
use App\ApiResource\State\SprintTemplate\SprintTemplateDeleteProcessor;
use App\ApiResource\State\SprintTemplate\SprintTemplateItemProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateUpdateProcessor;
use App\Entity\SprintTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'SprintTemplate',
    stateOptions: new Options(entityClass: SprintTemplate::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: SprintTemplateCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: SprintTemplateItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: SprintTemplateCreateProcessor::class,
            input: SprintTemplateCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: SprintTemplateUpdateProcessor::class,
            input: SprintTemplateUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: SprintTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class SprintTemplateResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public string $description;

    #[Groups(['collection:read', 'item:read'])]
    public int $duration;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
