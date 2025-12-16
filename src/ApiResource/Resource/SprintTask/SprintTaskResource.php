<?php

namespace App\ApiResource\Resource\SprintTask;

use App\Entity\SprintTask;

use App\Entity\SprintTemplate;
use App\Entity\TaskTemplate;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskUpdateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskResponseDto;
use App\ApiResource\Dto\SprintTask\SprintTaskCollectionResponse;

use App\ApiResource\State\SprintTask\SprintTaskProvider;
use App\ApiResource\State\SprintTask\SprintTaskProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'SprintTask',
    stateOptions: new Options(entityClass: SprintTask::class),
    operations: [
        new GetCollection(
            // security: "is_granted('SPRINT_TASK_LIST', object)",
            // normalizationContext: ['groups' => ['SprintTask:collection:read']],
            // provider: SprintTaskProvider::class,
            // output: SprintTaskCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('SPRINT_TASK_VIEW', object)",
            // normalizationContext: ['groups' => ['SprintTask:item:read']],
            // provider: SprintTaskProvider::class,
            // output: SprintTaskResponseDto::class
        ),
        new Post(
            // security: "is_granted('SPRINT_TASK_CREATE', object)",
            // denormalizationContext: ['groups' => ['SprintTask:create']],
            // processor: SprintTaskProcessor::class,
            // input: SprintTaskCreateDto::class
        ),
        new Patch(
            // security: "is_granted('SPRINT_TASK_EDIT', object)",
            // denormalizationContext: ['groups' => ['SprintTask:update']],
            // processor: SprintTaskProcessor::class,
            // input:SprintTaskeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('SPRINT_TASK_DELETE', object)",
            // processor: SprintTaskProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour SprintTask.
 * Utilisé pour exposer SprintTask.
 */
#[Map(source: SprintTask::class)]
final class SprintTaskResource
{
    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public int $id;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public int $taskOrder;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?SprintTemplate $sprintTemplate;

    #[Groups(['SprintTask:collection:read', 'SprintTask:item:read'])]
    public ?TaskTemplate $taskTemplate;
}
