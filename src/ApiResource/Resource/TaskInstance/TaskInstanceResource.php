<?php

namespace App\ApiResource\Resource\TaskInstance;

use App\Entity\TaskInstance;
use App\Entity\SprintInstance;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Link;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceItemDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCollectionItemDto;

use App\ApiResource\State\TaskInstance\TaskInstanceCollectionProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceItemProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceCreateProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceUpdateProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceDeleteProcessor;


#[ApiResource(
    shortName: 'TaskInstance',
    stateOptions: new Options(entityClass: TaskInstance::class),
    operations: [
        new GetCollection(
            uriTemplate: 'task_instances/current_sprint/{sprintId}',
            uriVariables: [
                'sprintId' => new Link(
                    fromClass: SprintInstance::class,
                    toProperty: 'sprintInstance',
                ),
            ],
            normalizationContext: ['groups' => ['TaskInstance:collection:read']],
            provider: TaskInstanceCollectionProvider::class,
            output: TaskInstanceCollectionItemDto::class
        ),
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

final class TaskInstanceResource
{
    public int $id;
}
