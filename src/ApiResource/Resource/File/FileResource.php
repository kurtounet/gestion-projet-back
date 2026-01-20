<?php

namespace App\ApiResource\Resource\File;

use App\Entity\File;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\File\FileCreateDto;
use App\ApiResource\Dto\File\FileUpdateDto;
use App\ApiResource\Dto\File\FileItemDto;
use App\ApiResource\Dto\File\FileCollectionItemDto;

use App\ApiResource\State\File\FileCollectionProvider;
use App\ApiResource\State\File\FileItemProvider;
use App\ApiResource\State\File\FileCreateProcessor;
use App\ApiResource\State\File\FileUpdateProcessor;
use App\ApiResource\State\File\FileDeleteProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'File',
    stateOptions: new Options(entityClass: File::class),
    operations: [
        new GetCollection(
            uriTemplate: 'files',
            normalizationContext: ['groups' => ['File:collection:read']],
            provider: FileCollectionProvider::class,
            output: FileCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'files/{id}',
            normalizationContext: ['groups' => ['File:item:read']],
            provider: FileItemProvider::class,
            output: FileItemDto::class
        ),
        new Post(
            uriTemplate: 'files',
            denormalizationContext: ['groups' => ['File:create']],
            processor: FileCreateProcessor::class,
            input: FileCreateDto::class,
            output: FileItemDto::class
        ),
        new Patch(
            uriTemplate: 'files/{id}',
            denormalizationContext: ['groups' => ['File:update']],
            processor: FileUpdateProcessor::class,
            input: FileUpdateDto::class,
            output: FileItemDto::class
        ),
        new Delete(
            uriTemplate: 'files/{id}',
            processor: FileDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
//#[Map(source: File::class)]
final class FileResource
{
    public int $id;
/*
    #[Groups(['File:collection:read', 'File:item:read'])]
    public int $id;

    #[Groups(['File:collection:read', 'File:item:read'])]
    public string $path;

    #[Groups(['File:collection:read', 'File:item:read'])]
    public string $keyWord;

    #[Groups(['File:collection:read', 'File:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['File:collection:read', 'File:item:read'])]
    public ?\DateTimeInterface $updatedAt;


*/
}
