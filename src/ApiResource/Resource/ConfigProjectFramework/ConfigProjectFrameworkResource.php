<?php

namespace App\ApiResource\Resource\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCreateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkItemDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCollectionItemDto;

use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkCollectionProvider;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkItemProvider;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkCreateProcessor;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkUpdateProcessor;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'ConfigProjectFramework',
    stateOptions: new Options(entityClass: ConfigProjectFramework::class),
    operations: [
        new GetCollection(
            uriTemplate: 'config_project_frameworks',
            normalizationContext: ['groups' => ['ConfigProjectFramework:collection:read']],
            provider: ConfigProjectFrameworkCollectionProvider::class,
            output: ConfigProjectFrameworkCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'config_project_frameworks/{id}',
            normalizationContext: ['groups' => ['ConfigProjectFramework:item:read']],
            provider: ConfigProjectFrameworkItemProvider::class,
            output: ConfigProjectFrameworkItemDto::class
        ),
        new Post(
            uriTemplate: 'config_project_frameworks',
            denormalizationContext: ['groups' => ['ConfigProjectFramework:create']],
            processor: ConfigProjectFrameworkCreateProcessor::class,
            input: ConfigProjectFrameworkCreateDto::class,
            output: ConfigProjectFrameworkItemDto::class
        ),
        new Patch(
            uriTemplate: 'config_project_frameworks/{id}',
            denormalizationContext: ['groups' => ['ConfigProjectFramework:update']],
            processor: ConfigProjectFrameworkUpdateProcessor::class,
            input: ConfigProjectFrameworkUpdateDto::class,
            output: ConfigProjectFrameworkItemDto::class
        ),
        new Delete(
            uriTemplate: 'config_project_frameworks/{id}',
            processor: ConfigProjectFrameworkDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: ConfigProjectFramework::class)]
final class ConfigProjectFrameworkResource
{
    public int $id;
/*
    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public int $id;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public string $name;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?array $configuration;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?array $architecture;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?array $script;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?string $projectInstance = null;

    #[Groups(['ConfigProjectFramework:collection:read', 'ConfigProjectFramework:item:read'])]
    public ?string $framework = null;

*/
}
