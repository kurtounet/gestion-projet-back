<?php

namespace App\ApiResource\Resource\Technology;

use App\Entity\Technology;

use App\Entity\Framework;
;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Technology\TechnologyCreateDto;
use App\ApiResource\Dto\Technology\TechnologyUpdateDto;
use App\ApiResource\Dto\Technology\TechnologyResponseDto;
use App\ApiResource\Dto\Technology\TechnologyCollectionResponse;

use App\ApiResource\State\Technology\TechnologyProvider;
use App\ApiResource\State\Technology\TechnologyProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Technology',
    stateOptions: new Options(entityClass: Technology::class),
    operations: [
        new GetCollection(
            // security: "is_granted('TECHNOLOGY_LIST', object)",
            // normalizationContext: ['groups' => ['Technology:collection:read']],
            // provider: TechnologyProvider::class,
            // output: TechnologyCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('TECHNOLOGY_VIEW', object)",
            // normalizationContext: ['groups' => ['Technology:item:read']],
            // provider: TechnologyProvider::class,
            // output: TechnologyResponseDto::class
        ),
        new Post(
            // security: "is_granted('TECHNOLOGY_CREATE', object)",
            // denormalizationContext: ['groups' => ['Technology:create']],
            // processor: TechnologyProcessor::class,
            // input: TechnologyCreateDto::class
        ),
        new Patch(
            // security: "is_granted('TECHNOLOGY_EDIT', object)",
            // denormalizationContext: ['groups' => ['Technology:update']],
            // processor: TechnologyProcessor::class,
            // input:TechnologyeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('TECHNOLOGY_DELETE', object)",
            // processor: TechnologyProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Technology.
 * Utilisé pour exposer Technology.
 */
#[Map(source: Technology::class)]
final class TechnologyResource
{
    #[Groups(['Technology:read'])]
    public int $id;

    #[Groups(['Technology:read'])]
    public string $label;

    #[Groups(['Technology:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Technology:read'])]
    public ?\DateTimeInterface $updatedAt;
    public array $framework = [];

}
