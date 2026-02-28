<?php

namespace App\ApiResource\Resource\ProjectInstance;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCreateDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceUpdateDto;
use App\ApiResource\State\ProjectInstance\ProjectInstanceCollectionProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceCreateProcessor;
use App\ApiResource\State\ProjectInstance\ProjectInstanceDeleteProcessor;
use App\ApiResource\State\ProjectInstance\ProjectInstanceItemProvider;
use App\ApiResource\State\ProjectInstance\ProjectInstanceUpdateProcessor;
use App\Entity\ProjectInstance;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ProjectInstance',
    stateOptions: new Options(entityClass: ProjectInstance::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ProjectInstanceCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ProjectInstanceItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ProjectInstanceCreateProcessor::class,
            input: ProjectInstanceCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ProjectInstanceUpdateProcessor::class,
            input: ProjectInstanceUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ProjectInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ProjectInstanceResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $pathFileDatabase = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $pathProject = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $description = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $icon = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $color = null;

    #[Groups(['collection:read', 'item:read'])]
    public bool $isFavory;

    #[Groups(['collection:read', 'item:read'])]
    public int $position;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $createdByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $updatedByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $status = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $priority = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $comment = null;

    #[Groups(['collection:read', 'item:read'])]
    public iterable $sprintInstances = [];

    #[Groups(['collection:read', 'item:read'])]
    public iterable $projectInstances = [];

    #[Groups(['collection:read', 'item:read'])]
    public ?string $parent = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $configFramework = null;


}
