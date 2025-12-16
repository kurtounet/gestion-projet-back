<?php

namespace App\ApiResource\Resource\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;

use App\Entity\ProjectInstance;
use App\Entity\Framework;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCreateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkResponseDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCollectionResponse;

use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkProvider;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ConfigProjectFramework',
    stateOptions: new Options(entityClass: ConfigProjectFramework::class),
    operations: [
        new GetCollection(
            // security: "is_granted('CONFIG_PROJECT_FRAMEWORK_LIST', object)",
            // normalizationContext: ['groups' => ['ConfigProjectFramework:collection:read']],
            // provider: ConfigProjectFrameworkProvider::class,
            // output: ConfigProjectFrameworkCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('CONFIG_PROJECT_FRAMEWORK_VIEW', object)",
            // normalizationContext: ['groups' => ['ConfigProjectFramework:item:read']],
            // provider: ConfigProjectFrameworkProvider::class,
            // output: ConfigProjectFrameworkResponseDto::class
        ),
        new Post(
            // security: "is_granted('CONFIG_PROJECT_FRAMEWORK_CREATE', object)",
            // denormalizationContext: ['groups' => ['ConfigProjectFramework:create']],
            // processor: ConfigProjectFrameworkProcessor::class,
            // input: ConfigProjectFrameworkCreateDto::class
        ),
        new Patch(
            // security: "is_granted('CONFIG_PROJECT_FRAMEWORK_EDIT', object)",
            // denormalizationContext: ['groups' => ['ConfigProjectFramework:update']],
            // processor: ConfigProjectFrameworkProcessor::class,
            // input:ConfigProjectFrameworkeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('CONFIG_PROJECT_FRAMEWORK_DELETE', object)",
            // processor: ConfigProjectFrameworkProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour ConfigProjectFramework.
 * Utilisé pour exposer ConfigProjectFramework.
 */
#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkResource
{
    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public int $id;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:item:read', 'ConfigProjectFramework:collection:read'])]
    public ?\DateTimeInterface $updatedAt;

    /*
    public ?ProjectInstance $projectInstance;
    public ?Framework $framework;
    */
}
