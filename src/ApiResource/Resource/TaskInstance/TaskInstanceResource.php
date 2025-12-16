<?php

namespace App\ApiResource\Resource\TaskInstance;



use App\Entity\User;
use App\Entity\TaskTemplate;
use App\Entity\SprintInstance;
use App\Entity\Priority;
use App\Entity\Status;
use App\Entity\TypeTask;
use App\Entity\TaskInstance;
use App\Entity\Comment;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceResponseDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCollectionResponse;

use App\ApiResource\State\TaskInstance\TaskInstanceProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TaskInstance',
    stateOptions: new Options(entityClass: TaskInstance::class),
    operations: [
        new GetCollection(
            // security: "is_granted('TASK_INSTANCE_LIST', object)",
            // normalizationContext: ['groups' => ['TaskInstance:collection:read']],
            // provider: TaskInstanceProvider::class,
            // output: TaskInstanceCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('TASK_INSTANCE_VIEW', object)",
            // normalizationContext: ['groups' => ['TaskInstance:item:read']],
            // provider: TaskInstanceProvider::class,
            // output: TaskInstanceResponseDto::class
        ),
        new Post(
            // security: "is_granted('TASK_INSTANCE_CREATE', object)",
            // denormalizationContext: ['groups' => ['TaskInstance:create']],
            // processor: TaskInstanceProcessor::class,
            // input: TaskInstanceCreateDto::class
        ),
        new Patch(
            // security: "is_granted('TASK_INSTANCE_EDIT', object)",
            // denormalizationContext: ['groups' => ['TaskInstance:update']],
            // processor: TaskInstanceProcessor::class,
            // input:TaskInstanceeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('TASK_INSTANCE_DELETE', object)",
            // processor: TaskInstanceProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour TaskInstance.
 * Utilisé pour exposer TaskInstance.
 */
#[Map(source: TaskInstance::class)]
final class TaskInstanceResource
{
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
    public ?User $user;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?TaskTemplate $taskTemplate;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?SprintInstance $sprintInstance;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?Priority $priority;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?Status $status;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?TypeTask $typeTask;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?TaskInstance $parentTask;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?TaskInstance $dependency;

    #[Groups(['TaskInstance:collection:read', 'TaskInstance:item:read'])]
    public ?Comment $comment;
}
