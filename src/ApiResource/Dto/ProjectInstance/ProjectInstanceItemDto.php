<?php

namespace App\ApiResource\Dto\ProjectInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use App\ApiResource\Resource\Status\StatusResource;
use App\Entity\Priority;
use App\Entity\ProjectInstance  as ProjectInstanceEntity;
use App\Entity\Status;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour ProjectInstance.
 * C'est le contrat public exposé par l'API.
 */


#[Map(source: ProjectInstanceEntity::class)]
final class ProjectInstanceItemDto
{

    public function __construct(

        #[ApiProperty(identifier: true)]
        #[Groups(['PI:item:read'])]
        public ?int $id = null,
        #[Groups(['PI:item:read'])]
        public ?string $name = null,
        #[Groups(['PI:item:read'])]
        public ?string $pathFileDatabase = null,
        #[Groups(['PI:item:read'])]
        public ?string $pathProject = null,
        #[Groups(['PI:item:read'])]
        public ?string $description = null,
        #[Groups(['PI:item:read'])]
        public ?string $icon = null,
        #[Groups(['PI:item:read'])]
        public ?string $color = null,
        #[Groups(['PI:item:read'])]
        public bool $isFavory = false,
        #[Groups(['PI:item:read'])]
        public int $position = 0,
        #[Groups(['PI:item:read'])]
        public ?\DateTimeInterface $startDate = null,
        #[Groups(['PI:item:read'])]
        public ?\DateTimeInterface $endDate = null,
        #[Groups(['PI:item:read'])]
        public ?string $createdByUser = null,
        #[Groups(['PI:item:read'])]
        public ?string $updatedByUser = null,
        #[Groups(['PI:item:read'])]
        public ?\DateTimeInterface $createdAt = null,
        #[Groups(['PI:item:read'])]
        public ?\DateTimeInterface $updatedAt = null,

        #[Groups(['PI:item:read'])]
        public ?string $status = null,
        #[Groups(['PI:item:read'])]
        public ?string $priority = null,
        #[Groups(['PI:item:read'])]
        public ?string $projectTemplate = null,
        #[Groups(['PI:item:read'])]
        public ?string $comment = null,

        // #[Groups(['PI:item:read'])]
        // public iterable $sprints = [],
    ) {}


    // #[ApiProperty(identifier: true)]
    // public ?int $id = null;
    // public ?string $name = null;
    // public ?string $pathFileDatabase = null;
    // public ?string $pathProject = null;
    // public ?string $description = null;
    // public ?string $icon = null;
    // public ?string $color = null;
    // public bool $isFavory = false;
    // public int $position = 0;
    // public ?\DateTimeInterface $startDate = null;
    // public ?\DateTimeInterface $endDate = null;
    // public ?string $createdByUser = null;
    // public ?string $updatedByUser = null;
    // public ?\DateTimeInterface $createdAt = null;
    // public ?\DateTimeInterface $updatedAt = null;
}
