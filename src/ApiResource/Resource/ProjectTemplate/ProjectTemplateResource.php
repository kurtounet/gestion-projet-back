<?php

namespace App\ApiResource\Resource\ProjectTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateUpdateDto;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateCollectionProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateCreateProcessor;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateDeleteProcessor;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateItemProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateUpdateProcessor;
use App\Entity\ProjectTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ProjectTemplate',
    stateOptions: new Options(entityClass: ProjectTemplate::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ProjectTemplateCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ProjectTemplateItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ProjectTemplateCreateProcessor::class,
            input: ProjectTemplateCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ProjectTemplateUpdateProcessor::class,
            input: ProjectTemplateUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ProjectTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ProjectTemplateResource
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
