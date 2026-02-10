<?php

namespace App\ApiResource\Resource\SprintInstance;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCollectionItemDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceItemDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\State\SprintInstance\SprintInstanceCollectionProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceCreateProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceDeleteProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceItemProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceUpdateProcessor;
use App\Entity\ProjectInstance;
use App\Entity\SprintInstance;

#[ApiResource(
    shortName: 'SprintInstance',
    stateOptions: new Options(entityClass: SprintInstance::class),
    operations: [
        new GetCollection(
            uriTemplate: 'sprint_instances/current_project/{projectId}',
            uriVariables: [
                'projectId' => new Link(
                    fromClass: ProjectInstance::class,
                    toProperty: 'projectInstance',
                ),
            ],
            normalizationContext: ['groups' => ['SprintInstance:collection:read']],
            provider: SprintInstanceCollectionProvider::class,
            output: SprintInstanceCollectionItemDto::class
        ),
        new GetCollection(
            uriTemplate: 'sprint_instances',
            normalizationContext: ['groups' => ['SprintInstance:collection:read']],
            provider: SprintInstanceCollectionProvider::class,
            output: SprintInstanceCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'sprint_instances/{id}',
            normalizationContext: ['groups' => ['SprintInstance:item:read']],
            provider: SprintInstanceItemProvider::class,
            output: SprintInstanceItemDto::class
        ),
        new Post(
            uriTemplate: 'sprint_instances',
            denormalizationContext: ['groups' => ['SprintInstance:create']],
            processor: SprintInstanceCreateProcessor::class,
            input: SprintInstanceCreateDto::class,
            output: SprintInstanceItemDto::class
        ),
        new Patch(
            uriTemplate: 'sprint_instances/{id}',
            denormalizationContext: ['groups' => ['SprintInstance:update']],
            processor: SprintInstanceUpdateProcessor::class,
            input: SprintInstanceUpdateDto::class,
            output: SprintInstanceItemDto::class
        ),
        new Delete(
            uriTemplate: 'sprint_instances/{id}',
            processor: SprintInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
final class SprintInstanceResource
{
    public int $id;
}
