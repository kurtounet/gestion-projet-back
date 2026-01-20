<?php

namespace App\ApiResource\Resource\SprintInstance;

use App\Entity\SprintInstance;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceItemDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCollectionItemDto;

use App\ApiResource\State\SprintInstance\SprintInstanceCollectionProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceItemProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceCreateProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceUpdateProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'SprintInstance',
    stateOptions: new Options(entityClass: SprintInstance::class),
    operations: [
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
//#[Map(source: SprintInstance::class)]
final class SprintInstanceResource
{
    public int $id;
/*
    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public int $id;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $name;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $description;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $icon;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $color;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?int $position;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $priority = null;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $status = null;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $comment = null;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $sprintDependency = null;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $projectInstance = null;

*/
}
