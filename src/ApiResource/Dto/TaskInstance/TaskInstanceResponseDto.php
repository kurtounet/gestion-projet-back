<?php

namespace App\ApiResource\Dto\TaskInstance;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\TaskInstance;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour TaskInstance.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'TaskInstance',
    stateOptions: new Options(entityClass: TaskInstance::class),
)]
#[Map(source: TaskInstance::class)]
final class TaskInstanceResponseDto
{
    #[Groups(['TaskInstance:read'])]
    public int $id;

    #[Groups(['TaskInstance:read'])]
    public string $name;

    #[Groups(['TaskInstance:read'])]
    public string $description;

    #[Groups(['TaskInstance:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['TaskInstance:read'])]
    public \DateTimeInterface $dueDate;

    #[Groups(['TaskInstance:read'])]
    public ?int $position;

    #[Groups(['TaskInstance:read'])]
    public string $icon;

    #[Groups(['TaskInstance:read'])]
    public string $color;

    #[Groups(['TaskInstance:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TaskInstance:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['TaskInstance:read'])]
    public ?string $createdByUser;

    #[Groups(['TaskInstance:read'])]
    public ?string $updatedByUser;
}
