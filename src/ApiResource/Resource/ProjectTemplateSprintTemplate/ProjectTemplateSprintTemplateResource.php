<?php

namespace App\ApiResource\Resource\ProjectTemplateSprintTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCollectionItemDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateItemDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCollectionProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateProcessor;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateDeleteProcessor;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateItemProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateProcessor;
use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ProjectTemplateSprintTemplate',
    stateOptions: new Options(entityClass: ProjectTemplateSprintTemplate::class),
    operations: [
        new GetCollection(
            uriTemplate: 'project_template_sprint_templates',
            normalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:collection:read']],
            provider: ProjectTemplateSprintTemplateCollectionProvider::class,
            output: ProjectTemplateSprintTemplateCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'project_template_sprint_templates/{id}',
            normalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:item:read']],
            provider: ProjectTemplateSprintTemplateItemProvider::class,
            output: ProjectTemplateSprintTemplateItemDto::class
        ),
        new Post(
            uriTemplate: 'project_template_sprint_templates',
            denormalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:create']],
            processor: ProjectTemplateSprintTemplateCreateProcessor::class,
            input: ProjectTemplateSprintTemplateCreateDto::class,
            output: ProjectTemplateSprintTemplateItemDto::class
        ),
        new Patch(
            uriTemplate: 'project_template_sprint_templates/{id}',
            denormalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:update']],
            processor: ProjectTemplateSprintTemplateUpdateProcessor::class,
            input: ProjectTemplateSprintTemplateUpdateDto::class,
            output: ProjectTemplateSprintTemplateItemDto::class
        ),
        new Delete(
            uriTemplate: 'project_template_sprint_templates/{id}',
            processor: ProjectTemplateSprintTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateResource
{
    public int $id;
    /*
        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public int $id;

        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public int $sprintOrder;

        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public ?\DateTimeInterface $updatedAt;

        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public ?string $projectTemplate = null;

        #[Groups(['ProjectTemplateSprintTemplate:collection:read', 'ProjectTemplateSprintTemplate:item:read'])]
        public ?string $sprintTemplate = null;

    */
}
