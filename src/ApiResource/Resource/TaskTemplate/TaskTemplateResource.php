<?php

namespace App\ApiResource\Resource\TaskTemplate;

use App\Entity\TaskTemplate;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateItemDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCollectionItemDto;

use App\ApiResource\State\TaskTemplate\TaskTemplateCollectionProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateItemProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateCreateProcessor;
use App\ApiResource\State\TaskTemplate\TaskTemplateUpdateProcessor;
use App\ApiResource\State\TaskTemplate\TaskTemplateDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TaskTemplate',
    stateOptions: new Options(entityClass: TaskTemplate::class),
    operations: [
        new GetCollection(
            uriTemplate: 'task_template',
            normalizationContext: ['groups' => ['TaskTemplate:collection:read']],
            provider: TaskTemplateCollectionProvider::class,
            output: TaskTemplateCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'task_template/{id}',
            normalizationContext: ['groups' => ['TaskTemplate:item:read']],
            provider: TaskTemplateItemProvider::class,
            output: TaskTemplateItemDto::class
        ),
        new Post(
            uriTemplate: 'task_template/{id}',
            denormalizationContext: ['groups' => ['TaskTemplate:create']],
            processor: TaskTemplateCreateProcessor::class,
            input: TaskTemplateCreateDto::class,
            output: TaskTemplateItemDto::class
        ),
        new Patch(
            uriTemplate: 'task_template/{id}',
            denormalizationContext: ['groups' => ['TaskTemplate:update']],
            processor: TaskTemplateUpdateProcessor::class,
            input: TaskTemplateUpdateDto::class,
            output: TaskTemplateItemDto::class
        ),
        new Delete(
            uriTemplate: 'task_template/{id}',
            processor: TaskTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: TaskTemplate::class)]
final class TaskTemplateResource
{
    public int $id;
/*
    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public int $id;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public string $name;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public string $description;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public int $parentTask;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public ?string $typeTask = null;

*/
}
