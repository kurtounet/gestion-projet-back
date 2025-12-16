<?php

namespace App\ApiResource\Resource\ProjectInstance;



use App\Entity\Status;
use App\Entity\Priority;
use App\Entity\Comment;
use App\Entity\SprintInstance;
use App\Entity\ProjectTemplate;
use App\Entity\ConfigProjectFramework;
use App\Entity\ProjectInstance as ProjectInstanceEntity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceResponseDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionResponse;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\ApiResource\Resource\Status\StatusResource;
use App\ApiResource\State\ProjectInstance\ProjectInstanceCollectionProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceItemProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ProjectInstance',

    stateOptions: new Options(entityClass: ProjectInstanceEntity::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['PI:collection:read']],
            output: ProjectInstanceCollectionItemDto::class,
            provider: ProjectInstanceCollectionProvider::class,
        ),
        new Get(
            normalizationContext: [
                'groups' => ['PI:item:read'],
                'jsonld_has_context' => true,
            ],
            // paginationEnabled: true,
            // output: ProjectInstanceItemDto::class,
            // provider: ProjectInstanceItemProvider::class,
        ),
        new Post(
            // security: "is_granted('PROJECT_INSTANCE_CREATE', object)",
            // denormalizationContext: ['groups' => ['ProjectInstance:create']],
            // processor: ProjectInstanceCreateProcessor::class,
            // input: ProjectInstanceCreateDto::class
        ),
        new Patch(
            // security: "is_granted('PROJECT_INSTANCE_EDIT', object)",
            // denormalizationContext: ['groups' => ['ProjectInstance:update']],
            // processor: ProjectInstancePatchProcessor::class,
            // input:ProjectInstanceeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('PROJECT_INSTANCE_DELETE', object)",
            // processor: ProjectInstanceDeleteProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour ProjectInstance.
 * Utilisé pour exposer ProjectInstance.
 */
// #[Map(source: ProjectInstanceEntity::class)]
final class ProjectInstanceResource
{

    #[ApiProperty(identifier: true)]
    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?int $id = null;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public string $name;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $pathFileDatabase;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $pathProject;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $description;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $icon;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $color;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public bool $isFavory;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public int $position;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $createdByUser;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $updatedByUser;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $status = null;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $priority = null;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['PI:item:read', 'PI:collection:read'])]
    public ?string $comment = null;
    /*
    // public iterable $sprintInstances = [];
    // public iterable $projectInstances = [];

    public ?string $parent;

    public ?string $configFramework;
    */
}
