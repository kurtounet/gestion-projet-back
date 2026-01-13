<?php

namespace App\ApiResource\Resource\ProjectInstance;

use App\Entity\ProjectInstance;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;

use App\ApiResource\State\ProjectInstance\ProjectInstanceCollectionProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceItemProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceCreateProcessor;
use App\ApiResource\State\ProjectInstance\ProjectInstanceUpdateProcessor;
use App\ApiResource\State\ProjectInstance\ProjectInstanceDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ProjectInstance',
    stateOptions: new Options(entityClass: ProjectInstance::class),
    operations: [
        new GetCollection(
            uriTemplate: 'project_instances',
            normalizationContext: ['groups' => ['ProjectInstance:collection:read']],
            provider: ProjectInstanceCollectionProvider::class,
            output: ProjectInstanceCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'project_instances/{id}',
            normalizationContext: ['groups' => ['ProjectInstance:item:read']],
            provider: ProjectInstanceItemProvider::class,
            output: ProjectInstanceItemDto::class
        ),
        new Post(
            uriTemplate: 'project_instances/{id}',
            denormalizationContext: ['groups' => ['ProjectInstance:create']],
            processor: ProjectInstanceCreateProcessor::class,
            input: ProjectInstanceCreateDto::class,
            output: ProjectInstanceItemDto::class
        ),
        new Patch(
            uriTemplate: 'project_instances/{id}',
            denormalizationContext: ['groups' => ['ProjectInstance:update']],
            processor: ProjectInstanceUpdateProcessor::class,
            input: ProjectInstanceUpdateDto::class,
            output: ProjectInstanceItemDto::class
        ),
        new Delete(
            uriTemplate: 'project_instances/{id}',
            processor: ProjectInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: ProjectInstance::class)]
final class ProjectInstanceResource
{
    public int $id;
    /*
    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public int $id;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public string $name;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $pathFileDatabase;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $pathProject;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $description;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $icon;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $color;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public bool $isFavory;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public int $position;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $comment = null;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public iterable $sprintInstances = [];

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public iterable $projectInstances = [];

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $parent = null;

    #[Groups(['ProjectInstance:collection:read', 'ProjectInstance:item:read'])]
    public ?string $configFramework = null;

*/
}
