<?php

namespace App\ApiResource\Resource\SprintTask;

use App\Entity\SprintTask;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskUpdateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskItemDto;
use App\ApiResource\Dto\SprintTask\SprintTaskCollectionItemDto;

use App\ApiResource\State\SprintTask\SprintTaskCollectionProvider;
use App\ApiResource\State\SprintTask\SprintTaskItemProvider;
use App\ApiResource\State\SprintTask\SprintTaskCreateProcessor;
use App\ApiResource\State\SprintTask\SprintTaskUpdateProcessor;
use App\ApiResource\State\SprintTask\SprintTaskDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'SprintTask',
    stateOptions: new Options(entityClass: SprintTask::class),
    operations: [
        new GetCollection(
            uriTemplate: 'sprint_task',
            normalizationContext: ['groups' => ['SprintTask:collection:read']],
            provider: SprintTaskCollectionProvider::class,
            output: SprintTaskCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'sprint_task/{id}',
            normalizationContext: ['groups' => ['SprintTask:item:read']],
            provider: SprintTaskItemProvider::class,
            output: SprintTaskItemDto::class
        ),
        new Post(
            uriTemplate: 'sprint_task/{id}',
            denormalizationContext: ['groups' => ['SprintTask:create']],
            processor: SprintTaskCreateProcessor::class,
            input: SprintTaskCreateDto::class,
            output: SprintTaskItemDto::class
        ),
        new Patch(
            uriTemplate: 'sprint_task/{id}',
            denormalizationContext: ['groups' => ['SprintTask:update']],
            processor: SprintTaskUpdateProcessor::class,
            input: SprintTaskUpdateDto::class,
            output: SprintTaskItemDto::class
        ),
        new Delete(
            uriTemplate: 'sprint_task/{id}',
            processor: SprintTaskDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: SprintTask::class)]
final class SprintTaskResource
{
    public int $id;
/*
    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public int $id;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public int $taskOrder;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?string $taskTemplate = null;

*/
}
