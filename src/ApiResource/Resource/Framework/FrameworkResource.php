<?php

namespace App\ApiResource\Resource\Framework;

use App\Entity\Framework;

use App\Entity\ConfigProjectFramework;
use App\Entity\Technology;
;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Framework\FrameworkCreateDto;
use App\ApiResource\Dto\Framework\FrameworkUpdateDto;
use App\ApiResource\Dto\Framework\FrameworkResponseDto;
use App\ApiResource\Dto\Framework\FrameworkCollectionResponse;

use App\ApiResource\State\Framework\FrameworkProvider;
use App\ApiResource\State\Framework\FrameworkProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Framework',
    stateOptions: new Options(entityClass: Framework::class),
    operations: [
        new GetCollection(
            // security: "is_granted('FRAMEWORK_LIST', object)",
            // normalizationContext: ['groups' => ['Framework:collection:read']],
            // provider: FrameworkProvider::class,
            // output: FrameworkCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('FRAMEWORK_VIEW', object)",
            // normalizationContext: ['groups' => ['Framework:item:read']],
            // provider: FrameworkProvider::class,
            // output: FrameworkResponseDto::class
        ),
        new Post(
            // security: "is_granted('FRAMEWORK_CREATE', object)",
            // denormalizationContext: ['groups' => ['Framework:create']],
            // processor: FrameworkProcessor::class,
            // input: FrameworkCreateDto::class
        ),
        new Patch(
            // security: "is_granted('FRAMEWORK_EDIT', object)",
            // denormalizationContext: ['groups' => ['Framework:update']],
            // processor: FrameworkProcessor::class,
            // input:FrameworkeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('FRAMEWORK_DELETE', object)",
            // processor: FrameworkProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Framework.
 * Utilisé pour exposer Framework.
 */
#[Map(source: Framework::class)]
final class FrameworkResource
{
    #[Groups(['Framework:read'])]
    public int $id;

    #[Groups(['Framework:read'])]
    public string $name;

    #[Groups(['Framework:read'])]
    public string $version;

    #[Groups(['Framework:read'])]
    public ?array $configuration;

    #[Groups(['Framework:read'])]
    public ?string $icon;

    #[Groups(['Framework:read'])]
    public ?string $color;
    public array $configProjectFrameworks = [];
    public ?Technology $technology;

}
