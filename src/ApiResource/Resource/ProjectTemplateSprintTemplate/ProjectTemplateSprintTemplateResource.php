<?php

namespace App\ApiResource\Resource\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplateSprintTemplate;

use App\Entity\ProjectTemplate;
use App\Entity\SprintTemplate;
;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCreateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateUpdateDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateResponseDto;
use App\ApiResource\Dto\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateCollectionResponse;

use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProvider;
use App\ApiResource\State\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ProjectTemplateSprintTemplate',
    stateOptions: new Options(entityClass: ProjectTemplateSprintTemplate::class),
    operations: [
        new GetCollection(
            // security: "is_granted('PROJECT_TEMPLATE_SPRINT_TEMPLATE_LIST', object)",
            // normalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:collection:read']],
            // provider: ProjectTemplateSprintTemplateProvider::class,
            // output: ProjectTemplateSprintTemplateCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('PROJECT_TEMPLATE_SPRINT_TEMPLATE_VIEW', object)",
            // normalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:item:read']],
            // provider: ProjectTemplateSprintTemplateProvider::class,
            // output: ProjectTemplateSprintTemplateResponseDto::class
        ),
        new Post(
            // security: "is_granted('PROJECT_TEMPLATE_SPRINT_TEMPLATE_CREATE', object)",
            // denormalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:create']],
            // processor: ProjectTemplateSprintTemplateProcessor::class,
            // input: ProjectTemplateSprintTemplateCreateDto::class
        ),
        new Patch(
            // security: "is_granted('PROJECT_TEMPLATE_SPRINT_TEMPLATE_EDIT', object)",
            // denormalizationContext: ['groups' => ['ProjectTemplateSprintTemplate:update']],
            // processor: ProjectTemplateSprintTemplateProcessor::class,
            // input:ProjectTemplateSprintTemplateeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('PROJECT_TEMPLATE_SPRINT_TEMPLATE_DELETE', object)",
            // processor: ProjectTemplateSprintTemplateProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour ProjectTemplateSprintTemplate.
 * Utilisé pour exposer ProjectTemplateSprintTemplate.
 */
#[Map(source: ProjectTemplateSprintTemplate::class)]
final class ProjectTemplateSprintTemplateResource
{
    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public int $id;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public int $sprintOrder;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ProjectTemplateSprintTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;
    public ?ProjectTemplate $projectTemplate;
    public ?SprintTemplate $sprintTemplate;

}
