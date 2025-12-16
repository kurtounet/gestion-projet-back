<?php

namespace App\ApiResource\Resource\TypeTask;

use App\Entity\TypeTask;

use App\Entity\CodeBase;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TypeTask\TypeTaskCreateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskUpdateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskResponseDto;
use App\ApiResource\Dto\TypeTask\TypeTaskCollectionResponse;

use App\ApiResource\State\TypeTask\TypeTaskProvider;
use App\ApiResource\State\TypeTask\TypeTaskProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TypeTask',
    stateOptions: new Options(entityClass: TypeTask::class),
    operations: [
        new GetCollection(
            // security: "is_granted('TYPE_TASK_LIST', object)",
            // normalizationContext: ['groups' => ['TypeTask:collection:read']],
            // provider: TypeTaskProvider::class,
            // output: TypeTaskCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('TYPE_TASK_VIEW', object)",
            // normalizationContext: ['groups' => ['TypeTask:item:read']],
            // provider: TypeTaskProvider::class,
            // output: TypeTaskResponseDto::class
        ),
        new Post(
            // security: "is_granted('TYPE_TASK_CREATE', object)",
            // denormalizationContext: ['groups' => ['TypeTask:create']],
            // processor: TypeTaskProcessor::class,
            // input: TypeTaskCreateDto::class
        ),
        new Patch(
            // security: "is_granted('TYPE_TASK_EDIT', object)",
            // denormalizationContext: ['groups' => ['TypeTask:update']],
            // processor: TypeTaskProcessor::class,
            // input:TypeTaskeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('TYPE_TASK_DELETE', object)",
            // processor: TypeTaskProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour TypeTask.
 * Utilisé pour exposer TypeTask.
 */
#[Map(source: TypeTask::class)]
final class TypeTaskResource
{
    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public int $id;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public string $name;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public ?string $color;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public string $pathFileScript;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public string $description;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public bool $automatique;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TypeTask:collection:read', 'TypeTask:item:read'])]
    public ?CodeBase $code;
}
