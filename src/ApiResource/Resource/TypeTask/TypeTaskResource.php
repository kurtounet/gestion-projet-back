<?php

namespace App\ApiResource\Resource\TypeTask;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\TypeTask\TypeTaskCreateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskUpdateDto;
use App\ApiResource\State\TypeTask\TypeTaskCollectionProvider;
use App\ApiResource\State\TypeTask\TypeTaskCreateProcessor;
use App\ApiResource\State\TypeTask\TypeTaskDeleteProcessor;
use App\ApiResource\State\TypeTask\TypeTaskItemProvider;
use App\ApiResource\State\TypeTask\TypeTaskUpdateProcessor;
use App\Entity\TypeTask;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'TypeTask',
    stateOptions: new Options(entityClass: TypeTask::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: TypeTaskCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: TypeTaskItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: TypeTaskCreateProcessor::class,
            input: TypeTaskCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: TypeTaskUpdateProcessor::class,
            input: TypeTaskUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: TypeTaskDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class TypeTaskResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $color = null;

    #[Groups(['collection:read', 'item:read'])]
    public string $pathFileScript;

    #[Groups(['collection:read', 'item:read'])]
    public string $description;

    #[Groups(['collection:read', 'item:read'])]
    public bool $automatique;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $code = null;


}
