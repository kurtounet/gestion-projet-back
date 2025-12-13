<?php

namespace App\ApiResource\Resource\SprintTemplate;

use App\Entity\SprintTemplate;

;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\SprintTemplate\SprintTemplateCreateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateUpdateDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateResponseDto;
use App\ApiResource\Dto\SprintTemplate\SprintTemplateCollectionResponse;

use App\ApiResource\State\SprintTemplate\SprintTemplateProvider;
use App\ApiResource\State\SprintTemplate\SprintTemplateProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'SprintTemplate',
    stateOptions: new Options(entityClass: SprintTemplate::class),
    operations: [
        new GetCollection(
            // security: "is_granted('SPRINT_TEMPLATE_LIST', object)",
            // normalizationContext: ['groups' => ['SprintTemplate:collection:read']],
            // provider: SprintTemplateProvider::class,
            // output: SprintTemplateCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('SPRINT_TEMPLATE_VIEW', object)",
            // normalizationContext: ['groups' => ['SprintTemplate:item:read']],
            // provider: SprintTemplateProvider::class,
            // output: SprintTemplateResponseDto::class
        ),
        new Post(
            // security: "is_granted('SPRINT_TEMPLATE_CREATE', object)",
            // denormalizationContext: ['groups' => ['SprintTemplate:create']],
            // processor: SprintTemplateProcessor::class,
            // input: SprintTemplateCreateDto::class
        ),
        new Patch(
            // security: "is_granted('SPRINT_TEMPLATE_EDIT', object)",
            // denormalizationContext: ['groups' => ['SprintTemplate:update']],
            // processor: SprintTemplateProcessor::class,
            // input:SprintTemplateeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('SPRINT_TEMPLATE_DELETE', object)",
            // processor: SprintTemplateProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour SprintTemplate.
 * Utilisé pour exposer SprintTemplate.
 */
#[Map(source: SprintTemplate::class)]
final class SprintTemplateResource
{
    #[Groups(['SprintTemplate:read'])]
    public int $id;

    #[Groups(['SprintTemplate:read'])]
    public string $name;

    #[Groups(['SprintTemplate:read'])]
    public string $description;

    #[Groups(['SprintTemplate:read'])]
    public int $duration;

    #[Groups(['SprintTemplate:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintTemplate:read'])]
    public ?\DateTimeInterface $updatedAt;

}
