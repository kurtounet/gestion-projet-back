<?php

namespace App\ApiResource\Resource\TaskTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\ApiResource\State\TaskTemplate\TaskTemplateCollectionProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateCreateProcessor;
use App\ApiResource\State\TaskTemplate\TaskTemplateDeleteProcessor;
use App\ApiResource\State\TaskTemplate\TaskTemplateItemProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateUpdateProcessor;
use App\Entity\TaskTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'TaskTemplate',
    stateOptions: new Options(entityClass: TaskTemplate::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: TaskTemplateCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: TaskTemplateItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: TaskTemplateCreateProcessor::class,
            input: TaskTemplateCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: TaskTemplateUpdateProcessor::class,
            input: TaskTemplateUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: TaskTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class TaskTemplateResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public string $description;

    #[Groups(['collection:read', 'item:read'])]
    public int $parentTask;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $typeTask = null;


}
