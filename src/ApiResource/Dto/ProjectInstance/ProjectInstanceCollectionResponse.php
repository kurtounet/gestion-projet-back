<?php

namespace App\ApiResource\Dto\ProjectInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use App\Entity\ProjectInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ProjectInstance.
 * C'est le contrat public exposé par l'API.
 */
// #[ApiResource(
//     shortName: 'ProjectInstance',
//     stateOptions: new Options(entityClass: ProjectInstance::class),
// )]
#[Map(source: ProjectInstance::class)]
final class ProjectInstanceCollectionResponse
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        public ?int $id = null,
        public ?string $name = null,
        public ?string $pathFileDatabase = null,
        public ?string $pathProject = null,
        public ?string $description = null,
        public ?string $icon = null,
        public ?string $color = null,
        public bool $isFavory = false,
        public int $position = 0,
        public ?\DateTimeInterface $startDate = null,
        public ?\DateTimeInterface $endDate = null,
        public ?string $createdByUser = null,
        public ?string $updatedByUser = null,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $updatedAt = null,
    ) {}
}
