<?php

namespace App\ApiResource\Resource\SprintTask;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\SprintTask\SprintTaskCreateDto;
use App\ApiResource\Dto\SprintTask\SprintTaskUpdateDto;
use App\ApiResource\State\SprintTask\SprintTaskCollectionProvider;
use App\ApiResource\State\SprintTask\SprintTaskCreateProcessor;
use App\ApiResource\State\SprintTask\SprintTaskDeleteProcessor;
use App\ApiResource\State\SprintTask\SprintTaskItemProvider;
use App\ApiResource\State\SprintTask\SprintTaskUpdateProcessor;
use App\Entity\SprintTask;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'SprintTask',
    stateOptions: new Options(entityClass: SprintTask::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: SprintTaskCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: SprintTaskItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: SprintTaskCreateProcessor::class,
            input: SprintTaskCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: SprintTaskUpdateProcessor::class,
            input: SprintTaskUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: SprintTaskDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class SprintTaskResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public int $taskOrder;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $taskTemplate = null;


}
