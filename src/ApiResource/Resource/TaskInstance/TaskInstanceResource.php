<?php

namespace App\ApiResource\Resource\TaskInstance;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\TaskInstance\TaskInstanceCreateDto;
use App\ApiResource\Dto\TaskInstance\TaskInstanceUpdateDto;
use App\ApiResource\Resource\SprintInstance\SprintInstanceResource;
use App\ApiResource\State\TaskInstance\TaskInstanceCollectionProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceCreateProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceDeleteProcessor;
use App\ApiResource\State\TaskInstance\TaskInstanceItemProvider;
use App\ApiResource\State\TaskInstance\TaskInstanceUpdateProcessor;
use App\Entity\TaskInstance;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'TaskInstance',
    stateOptions: new Options(entityClass: TaskInstance::class),
    operations: [
        new GetCollection(
            uriTemplate: 'task_instances/current_sprint/{sprintId}',
            uriVariables: [
                'sprintId' => new Link(
                    fromClass: SprintInstanceResource::class,
                    toProperty: 'sprintInstance',
                ),
            ],
            normalizationContext: ['groups' => ['collection:read']],
            provider: TaskInstanceCollectionProvider::class,
            output: self::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: TaskInstanceCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: TaskInstanceItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: TaskInstanceCreateProcessor::class,
            input: TaskInstanceCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: TaskInstanceUpdateProcessor::class,
            input: TaskInstanceUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: TaskInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class TaskInstanceResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public string $description;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['collection:read', 'item:read'])]
    public ?int $position = null;

    #[Groups(['collection:read', 'item:read'])]
    public string $icon;

    #[Groups(['collection:read', 'item:read'])]
    public string $color;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $createdByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $updatedByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $user = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $taskTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintInstance = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $priority = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $status = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $typeTask = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $parentTask = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $dependency = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $comment = null;


}
