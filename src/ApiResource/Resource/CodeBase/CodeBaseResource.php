<?php

namespace App\ApiResource\Resource\CodeBase;

use App\Entity\CodeBase;

;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\CodeBase\CodeBaseCreateDto;
use App\ApiResource\Dto\CodeBase\CodeBaseUpdateDto;
use App\ApiResource\Dto\CodeBase\CodeBaseResponseDto;
use App\ApiResource\Dto\CodeBase\CodeBaseCollectionResponse;

use App\ApiResource\State\CodeBase\CodeBaseProvider;
use App\ApiResource\State\CodeBase\CodeBaseProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'CodeBase',
    stateOptions: new Options(entityClass: CodeBase::class),
    operations: [
        new GetCollection(
            // security: "is_granted('CODE_BASE_LIST', object)",
            // normalizationContext: ['groups' => ['CodeBase:collection:read']],
            // provider: CodeBaseProvider::class,
            // output: CodeBaseCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('CODE_BASE_VIEW', object)",
            // normalizationContext: ['groups' => ['CodeBase:item:read']],
            // provider: CodeBaseProvider::class,
            // output: CodeBaseResponseDto::class
        ),
        new Post(
            // security: "is_granted('CODE_BASE_CREATE', object)",
            // denormalizationContext: ['groups' => ['CodeBase:create']],
            // processor: CodeBaseProcessor::class,
            // input: CodeBaseCreateDto::class
        ),
        new Patch(
            // security: "is_granted('CODE_BASE_EDIT', object)",
            // denormalizationContext: ['groups' => ['CodeBase:update']],
            // processor: CodeBaseProcessor::class,
            // input:CodeBaseeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('CODE_BASE_DELETE', object)",
            // processor: CodeBaseProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour CodeBase.
 * Utilisé pour exposer CodeBase.
 */
#[Map(source: CodeBase::class)]
final class CodeBaseResource
{
    #[Groups(['CodeBase:read'])]
    public int $id;

    #[Groups(['CodeBase:read'])]
    public string $label;

    #[Groups(['CodeBase:read'])]
    public string $code;

    #[Groups(['CodeBase:read'])]
    public string $pathFile;

    #[Groups(['CodeBase:read'])]
    public string $feature;

    #[Groups(['CodeBase:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['CodeBase:read'])]
    public ?\DateTimeInterface $updatedAt;

}
