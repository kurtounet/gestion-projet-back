<?php

namespace App\ApiResource\Resource\File;

use App\Entity\File;

;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\File\FileCreateDto;
use App\ApiResource\Dto\File\FileUpdateDto;
use App\ApiResource\Dto\File\FileResponseDto;
use App\ApiResource\Dto\File\FileCollectionResponse;

use App\ApiResource\State\File\FileProvider;
use App\ApiResource\State\File\FileProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'File',
    stateOptions: new Options(entityClass: File::class),
    operations: [
        new GetCollection(
            // security: "is_granted('FILE_LIST', object)",
            // normalizationContext: ['groups' => ['File:collection:read']],
            // provider: FileProvider::class,
            // output: FileCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('FILE_VIEW', object)",
            // normalizationContext: ['groups' => ['File:item:read']],
            // provider: FileProvider::class,
            // output: FileResponseDto::class
        ),
        new Post(
            // security: "is_granted('FILE_CREATE', object)",
            // denormalizationContext: ['groups' => ['File:create']],
            // processor: FileProcessor::class,
            // input: FileCreateDto::class
        ),
        new Patch(
            // security: "is_granted('FILE_EDIT', object)",
            // denormalizationContext: ['groups' => ['File:update']],
            // processor: FileProcessor::class,
            // input:FileeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('FILE_DELETE', object)",
            // processor: FileProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour File.
 * Utilisé pour exposer File.
 */
#[Map(source: File::class)]
final class FileResource
{
    #[Groups(['File:read'])]
    public int $id;

    #[Groups(['File:read'])]
    public string $path;

    #[Groups(['File:read'])]
    public string $keyWord;

    #[Groups(['File:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:read'])]
    public ?\DateTimeInterface $updatedAt;

}
