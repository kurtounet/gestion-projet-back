<?php

namespace App\ApiResource\Resource\TypeTask;

use App\Entity\TypeTask;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\TypeTask\TypeTaskCreateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskUpdateDto;
use App\ApiResource\Dto\TypeTask\TypeTaskItemDto;
use App\ApiResource\Dto\TypeTask\TypeTaskCollectionItemDto;

use App\ApiResource\State\TypeTask\TypeTaskCollectionProvider;
use App\ApiResource\State\TypeTask\TypeTaskItemProvider;
use App\ApiResource\State\TypeTask\TypeTaskCreateProcessor;
use App\ApiResource\State\TypeTask\TypeTaskUpdateProcessor;
use App\ApiResource\State\TypeTask\TypeTaskDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'TypeTask',
    stateOptions: new Options(entityClass: TypeTask::class),
    operations: [
        new GetCollection(
            uriTemplate: 'type_tasks',
            normalizationContext: ['groups' => ['TypeTask:collection:read']],
            provider: TypeTaskCollectionProvider::class,
            output: TypeTaskCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'type_tasks/{id}',
            normalizationContext: ['groups' => ['TypeTask:item:read']],
            provider: TypeTaskItemProvider::class,
            output: TypeTaskItemDto::class
        ),
        new Post(
            uriTemplate: 'type_tasks/{id}',
            denormalizationContext: ['groups' => ['TypeTask:create']],
            processor: TypeTaskCreateProcessor::class,
            input: TypeTaskCreateDto::class,
            output: TypeTaskItemDto::class
        ),
        new Patch(
            uriTemplate: 'type_tasks/{id}',
            denormalizationContext: ['groups' => ['TypeTask:update']],
            processor: TypeTaskUpdateProcessor::class,
            input: TypeTaskUpdateDto::class,
            output: TypeTaskItemDto::class
        ),
        new Delete(
            uriTemplate: 'type_tasks/{id}',
            processor: TypeTaskDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: TypeTask::class)]
final class TypeTaskResource
{
    public int $id;
    /*
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
    public ?string $code = null;

*/
}
