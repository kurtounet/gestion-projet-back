<?php

namespace App\ApiResource\Resource\Framework;

use App\Entity\Framework;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Dto\Framework\FrameworkUpdateDto;
use App\ApiResource\Dto\Framework\FrameworkItemDto;
use App\ApiResource\Dto\Framework\FrameworkCollectionItemDto;

use App\ApiResource\State\Framework\FrameworkCollectionProvider;
use App\ApiResource\State\Framework\FrameworkItemProvider;
use App\ApiResource\State\Framework\FrameworkCreateProcessor;
use App\ApiResource\State\Framework\FrameworkUpdateProcessor;
use App\ApiResource\State\Framework\FrameworkDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Framework',
    stateOptions: new Options(entityClass: Framework::class),
    operations: [
        new GetCollection(
            uriTemplate: 'frameworks',
            normalizationContext: ['groups' => ['Framework:collection:read']],
            provider: FrameworkCollectionProvider::class,
            output: FrameworkCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'frameworks/{id}',
            normalizationContext: ['groups' => ['Framework:item:read']],
            provider: FrameworkItemProvider::class,
            output: FrameworkItemDto::class
        ),
        new Post(
            uriTemplate: 'frameworks/{id}',
            denormalizationContext: ['groups' => ['Framework:create']],
            processor: FrameworkCreateProcessor::class,
            input: FrameworkCreateDto::class,
            output: FrameworkItemDto::class
        ),
        new Patch(
            uriTemplate: 'frameworks/{id}',
            denormalizationContext: ['groups' => ['Framework:update']],
            processor: FrameworkUpdateProcessor::class,
            input: FrameworkUpdateDto::class,
            output: FrameworkItemDto::class
        ),
        new Delete(
            uriTemplate: 'frameworks/{id}',
            processor: FrameworkDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: Framework::class)]
final class FrameworkResource
{
    public int $id;
    /*
    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public int $id;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public string $name;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public string $version;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public ?array $configuration;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public ?string $icon;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public ?string $color;

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public iterable $configProjectFrameworks = [];

    #[Groups(['Framework:collection:read', 'Framework:item:read'])]
    public ?string $technology = null;

*/
}
