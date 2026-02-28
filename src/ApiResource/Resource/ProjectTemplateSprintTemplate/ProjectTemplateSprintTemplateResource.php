<?php

namespace App\ApiResource\Resource\ProjectTemplateSprintTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCollectionProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateProcessor;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateDeleteProcessor;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateItemProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateProcessor;
use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ProjectTemplateSprintTemplate',
    stateOptions: new Options(entityClass: ProjectTemplateSprintTemplate::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ProjectTemplateSprintTemplateCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ProjectTemplateSprintTemplateItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ProjectTemplateSprintTemplateCreateProcessor::class,
            input: ProjectTemplateSprintTemplateCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ProjectTemplateSprintTemplateUpdateProcessor::class,
            input: ProjectTemplateSprintTemplateUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ProjectTemplateSprintTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ProjectTemplateSprintTemplateResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public int $sprintOrder;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $projectTemplate = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $sprintTemplate = null;


}
