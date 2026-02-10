<?php

namespace App\ApiResource\Resource\SprintTemplate;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateCollectionItemDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateCreateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateItemDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateUpdateDto;
use App\ApiResource\State\SprintTemplate\SprintTemplateCollectionProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateCreateProcessor;
use App\ApiResource\State\SprintTemplate\SprintTemplateDeleteProcessor;
use App\ApiResource\State\SprintTemplate\SprintTemplateItemProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateUpdateProcessor;
use App\Entity\SprintTemplate;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'SprintTemplate',
    stateOptions: new Options(entityClass: SprintTemplate::class),
    operations: [
        new GetCollection(
            uriTemplate: 'sprint_templates',
            normalizationContext: ['groups' => ['SprintTemplate:collection:read']],
            provider: SprintTemplateCollectionProvider::class,
            output: SprintTemplateCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'sprint_templates/{id}',
            normalizationContext: ['groups' => ['SprintTemplate:item:read']],
            provider: SprintTemplateItemProvider::class,
            output: SprintTemplateItemDto::class
        ),
        new Post(
            uriTemplate: 'sprint_templates',
            denormalizationContext: ['groups' => ['SprintTemplate:create']],
            processor: SprintTemplateCreateProcessor::class,
            input: SprintTemplateCreateDto::class,
            output: SprintTemplateItemDto::class
        ),
        new Patch(
            uriTemplate: 'sprint_templates/{id}',
            denormalizationContext: ['groups' => ['SprintTemplate:update']],
            processor: SprintTemplateUpdateProcessor::class,
            input: SprintTemplateUpdateDto::class,
            output: SprintTemplateItemDto::class
        ),
        new Delete(
            uriTemplate: 'sprint_templates/{id}',
            processor: SprintTemplateDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: SprintTemplate::class)]
final class SprintTemplateResource
{
    public int $id;
    /*
        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public int $id;

        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public string $name;

        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public string $description;

        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public int $duration;

        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public \DateTimeInterface $createdAt;

        #[Groups(['SprintTemplate:collection:read', 'SprintTemplate:item:read'])]
        public ?\DateTimeInterface $updatedAt;


    */
}
