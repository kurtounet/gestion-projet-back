<?php

namespace App\ApiResource\Resource\File;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\File\FileCreateDto;
use App\ApiResource\Dto\File\FileUpdateDto;
use App\ApiResource\State\File\FileCollectionProvider;
use App\ApiResource\State\File\FileCreateProcessor;
use App\ApiResource\State\File\FileDeleteProcessor;
use App\ApiResource\State\File\FileItemProvider;
use App\ApiResource\State\File\FileUpdateProcessor;
use App\Entity\File;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'File',
    stateOptions: new Options(entityClass: File::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: FileCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: FileItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: FileCreateProcessor::class,
            input: FileCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: FileUpdateProcessor::class,
            input: FileUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: FileDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class FileResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $path;

    #[Groups(['collection:read', 'item:read'])]
    public string $keyWord;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;



}
