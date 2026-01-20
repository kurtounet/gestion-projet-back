<?php

namespace App\ApiResource\Resource\TaskInstance;

use App\Entity\TaskInstance;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceItemDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCollectionItemDto;

use App\ApiResource\State\TaskInstance\TaskInstanceCollectionProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceItemProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceCreateProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceUpdateProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TaskInstance',
    stateOptions: new Options(entityClass: TaskInstance::class),
    operations: [
        new GetCollection(
            uriTemplate: 'task_instances',
            normalizationContext: ['groups' => ['TaskInstance:collection:read']],
            provider: TaskInstanceCollectionProvider::class,
            output: TaskInstanceCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'task_instances/{id}',
            normalizationContext: ['groups' => ['TaskInstance:item:read']],
            provider: TaskInstanceItemProvider::class,
            output: TaskInstanceItemDto::class
        ),
        new Post(
            uriTemplate: 'task_instances',
            denormalizationContext: ['groups' => ['TaskInstance:create']],
            processor: TaskInstanceCreateProcessor::class,
            input: TaskInstanceCreateDto::class,
            output: TaskInstanceItemDto::class
        ),
        new Patch(
            uriTemplate: 'task_instances/{id}',
            denormalizationContext: ['groups' => ['TaskInstance:update']],
            processor: TaskInstanceUpdateProcessor::class,
            input: TaskInstanceUpdateDto::class,
            output: TaskInstanceItemDto::class
        ),
        new Delete(
            uriTemplate: 'task_instances/{id}',
            processor: TaskInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: TaskInstance::class)]
final class TaskInstanceResource
{
    public int $id;
/*
    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public int $id;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public string $name;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public string $description;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?int $position;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public string $icon;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public string $color;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $user = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $taskTemplate = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $sprintInstance = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $typeTask = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $parentTask = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $dependency = null;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?string $comment = null;

*/
}
