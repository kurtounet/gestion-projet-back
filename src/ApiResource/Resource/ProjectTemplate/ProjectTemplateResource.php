<?php

namespace App\ApiResource\Resource\ProjectTemplate;

use App\Entity\ProjectTemplate;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateUpdateDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateItemDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCollectionItemDto;

use App\ApiResource\State\ProjectTemplate\ProjectTemplateCollectionProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateItemProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateCreateProcessor;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateUpdateProcessor;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ProjectTemplate',
    stateOptions: new Options(entityClass: ProjectTemplate::class),
    operations: [
        new GetCollection(
            uriTemplate: 'project_template',
            normalizationContext: ['groups' => ['ProjectTemplate:collection:read']],
            provider: ProjectTemplateCollectionProvider::class,
            output: ProjectTemplateCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'project_template/{id}',
            normalizationContext: ['groups' => ['ProjectTemplate:item:read']],
            provider: ProjectTemplateItemProvider::class,
            output: ProjectTemplateItemDto::class
        ),
        new Post(
            uriTemplate: 'project_template/{id}',
            denormalizationContext: ['groups' => ['ProjectTemplate:create']],
            processor: ProjectTemplateCreateProcessor::class,
            input: ProjectTemplateCreateDto::class,
            output: ProjectTemplateItemDto::class
        ),
        new Patch(
            uriTemplate: 'project_template/{id}',
            denormalizationContext: ['groups' => ['ProjectTemplate:update']],
            processor: ProjectTemplateUpdateProcessor::class,
            input: ProjectTemplateUpdateDto::class,
            output: ProjectTemplateItemDto::class
        ),
        new Delete(
            uriTemplate: 'project_template/{id}',
            processor: ProjectTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: ProjectTemplate::class)]
final class ProjectTemplateResource
{
    public int $id;
/*
    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public int $id;

    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public string $name;

    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public string $description;

    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public int $duration;

    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:collection:read', 'ProjectTemplate:item:read'])]
    public ?\DateTimeInterface $updatedAt;


*/
}
