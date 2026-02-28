<?php

namespace App\ApiResource\Resource\SprintInstance;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\State\SprintInstance\SprintInstanceCollectionProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceCreateProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceDeleteProcessor;
use App\ApiResource\State\SprintInstance\SprintInstanceItemProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceUpdateProcessor;
use App\Entity\SprintInstance;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'SprintInstance',
    stateOptions: new Options(entityClass: SprintInstance::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: SprintInstanceCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: SprintInstanceItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: SprintInstanceCreateProcessor::class,
            input: SprintInstanceCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: SprintInstanceUpdateProcessor::class,
            input: SprintInstanceUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: SprintInstanceDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class SprintInstanceResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public string $description;

    #[Groups(['collection:read', 'item:read'])]
    public string $icon;

    #[Groups(['collection:read', 'item:read'])]
    public string $color;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['collection:read', 'item:read'])]
    public ?int $position = null;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $createdByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $updatedByUser = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $priority = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $status = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $comment = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintDependency = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $projectInstance = null;


}
