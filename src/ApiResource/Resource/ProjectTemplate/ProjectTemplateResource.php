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
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateResponseDto;
use App\ApiResource\Dto\ProjectTemplate\ProjectTemplateCollectionResponse;

use App\ApiResource\State\ProjectTemplate\ProjectTemplateProvider;
use App\ApiResource\State\ProjectTemplate\ProjectTemplateProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ProjectTemplate',
    stateOptions: new Options(entityClass: ProjectTemplate::class),
    operations: [
        new GetCollection(
            // security: "is_granted('PROJECT_TEMPLATE_LIST', object)",
            // normalizationContext: ['groups' => ['ProjectTemplate:collection:read']],
            // provider: ProjectTemplateProvider::class,
            // output: ProjectTemplateCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('PROJECT_TEMPLATE_VIEW', object)",
            // normalizationContext: ['groups' => ['ProjectTemplate:item:read']],
            // provider: ProjectTemplateProvider::class,
            // output: ProjectTemplateResponseDto::class
        ),
        new Post(
            // security: "is_granted('PROJECT_TEMPLATE_CREATE', object)",
            // denormalizationContext: ['groups' => ['ProjectTemplate:create']],
            // processor: ProjectTemplateProcessor::class,
            // input: ProjectTemplateCreateDto::class
        ),
        new Patch(
            // security: "is_granted('PROJECT_TEMPLATE_EDIT', object)",
            // denormalizationContext: ['groups' => ['ProjectTemplate:update']],
            // processor: ProjectTemplateProcessor::class,
            // input:ProjectTemplateeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('PROJECT_TEMPLATE_DELETE', object)",
            // processor: ProjectTemplateProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour ProjectTemplate.
 * Utilisé pour exposer ProjectTemplate.
 */
#[Map(source: ProjectTemplate::class)]
final class ProjectTemplateResource
{
    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public int $id;

    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public string $name;

    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public string $description;

    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public int $duration;

    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplate:item:read', 'ProjectTemplate:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
