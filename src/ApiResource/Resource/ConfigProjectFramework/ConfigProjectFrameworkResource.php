<?php

namespace App\ApiResource\Resource\ConfigProjectFramework;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkCreateDto;
use App\ApiResource\Dto\ConfigProjectFramework\ConfigProjectFrameworkUpdateDto;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkCollectionProvider;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkCreateProcessor;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkDeleteProcessor;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkItemProvider;
use App\ApiResource\State\ConfigProjectFramework\ConfigProjectFrameworkUpdateProcessor;
use App\Entity\ConfigProjectFramework;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'ConfigProjectFramework',
    stateOptions: new Options(entityClass: ConfigProjectFramework::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: ConfigProjectFrameworkCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: ConfigProjectFrameworkItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: ConfigProjectFrameworkCreateProcessor::class,
            input: ConfigProjectFrameworkCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: ConfigProjectFrameworkUpdateProcessor::class,
            input: ConfigProjectFrameworkUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: ConfigProjectFrameworkDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class ConfigProjectFrameworkResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $name;

    #[Groups(['collection:read', 'item:read'])]
    public ?array $configuration = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?array $architecture = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?array $script = null;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $projectInstance = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $framework = null;


}
