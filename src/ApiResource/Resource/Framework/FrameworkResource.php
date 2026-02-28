<?php

namespace App\ApiResource\Resource\Framework;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Dto\Framework\FrameworkUpdateDto;
use App\ApiResource\State\Framework\FrameworkCollectionProvider;
use App\ApiResource\State\Framework\FrameworkCreateProcessor;
use App\ApiResource\State\Framework\FrameworkDeleteProcessor;
use App\ApiResource\State\Framework\FrameworkItemProvider;
use App\ApiResource\State\Framework\FrameworkUpdateProcessor;
use App\Entity\Framework;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Framework',
    stateOptions: new Options(entityClass: Framework::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: FrameworkCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: FrameworkItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: FrameworkCreateProcessor::class,
            input: FrameworkCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: FrameworkUpdateProcessor::class,
            input: FrameworkUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: FrameworkDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class FrameworkResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $label;

    #[Groups(['collection:read', 'item:read'])]
    public string $type;

    #[Groups(['collection:read', 'item:read'])]
    public string $version;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $description = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?array $configuration = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $icon = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $color = null;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public iterable $configProjectFrameworks = [];

    #[Groups(['collection:read', 'item:read'])]
    public ?string $technology = null;


}
