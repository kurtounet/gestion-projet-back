<?php

namespace App\ApiResource\Resource\TaskTemplate;

use App\Entity\TaskTemplate;

use App\Entity\SprintTemplate;
use App\Entity\TypeTask;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TaskTemplate\TaskTemplateCreateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateUpdateDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateResponseDto;
use App\ApiResource\Dto\TaskTemplate\TaskTemplateCollectionResponse;

use App\ApiResource\State\TaskTemplate\TaskTemplateProvider;
use App\ApiResource\State\TaskTemplate\TaskTemplateProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TaskTemplate',
    stateOptions: new Options(entityClass: TaskTemplate::class),
    operations: [
        new GetCollection(
            // security: "is_granted('TASK_TEMPLATE_LIST', object)",
            // normalizationContext: ['groups' => ['TaskTemplate:collection:read']],
            // provider: TaskTemplateProvider::class,
            // output: TaskTemplateCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('TASK_TEMPLATE_VIEW', object)",
            // normalizationContext: ['groups' => ['TaskTemplate:item:read']],
            // provider: TaskTemplateProvider::class,
            // output: TaskTemplateResponseDto::class
        ),
        new Post(
            // security: "is_granted('TASK_TEMPLATE_CREATE', object)",
            // denormalizationContext: ['groups' => ['TaskTemplate:create']],
            // processor: TaskTemplateProcessor::class,
            // input: TaskTemplateCreateDto::class
        ),
        new Patch(
            // security: "is_granted('TASK_TEMPLATE_EDIT', object)",
            // denormalizationContext: ['groups' => ['TaskTemplate:update']],
            // processor: TaskTemplateProcessor::class,
            // input:TaskTemplateeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('TASK_TEMPLATE_DELETE', object)",
            // processor: TaskTemplateProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour TaskTemplate.
 * Utilisé pour exposer TaskTemplate.
 */
#[Map(source: TaskTemplate::class)]
final class TaskTemplateResource
{
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
    public ?SprintTemplate $sprintTemplate;

    #[Groups(['TaskTemplate:collection:read', 'TaskTemplate:item:read'])]
    public ?TypeTask $typeTask;
}
