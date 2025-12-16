<?php

namespace App\ApiResource\Dto\ProjectInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use App\Entity\ProjectInstance as ProjectInstanceEntity;
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
#[Map(source: ProjectInstanceEntity::class)]
final class ProjectInstanceCollectionItemDto
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['PI:collection:read'])]
        public ?int $id = null,
        #[Groups(['PI:collection:read'])]
        public ?string $name = null,
        #[Groups(['PI:collection:read'])]
        public ?string $pathFileDatabase = null,
        #[Groups(['PI:collection:read'])]
        public ?string $pathProject = null,
        #[Groups(['PI:collection:read'])]
        public ?string $description = null,
        #[Groups(['PI:collection:read'])]
        public ?string $icon = null,
        #[Groups(['PI:collection:read'])]
        public ?string $color = null,
        #[Groups(['PI:collection:read'])]
        public bool $isFavory = false,
        #[Groups(['PI:collection:read'])]
        public int $position = 0,
        #[Groups(['PI:collection:read'])]
        public ?\DateTimeInterface $startDate = null,
        #[Groups(['PI:collection:read'])]
        public ?\DateTimeInterface $endDate = null,
        #[Groups(['PI:collection:read'])]
        public ?string $createdByUser = null,
        #[Groups(['PI:collection:read'])]
        public ?string $updatedByUser = null,
        #[Groups(['PI:collection:read'])]
        public ?\DateTimeInterface $createdAt = null,
        #[Groups(['PI:collection:read'])]
        public ?\DateTimeInterface $updatedAt = null,
    ) {}
}
