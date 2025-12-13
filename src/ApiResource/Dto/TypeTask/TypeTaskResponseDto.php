<?php

namespace App\ApiResource\Dto\TypeTask;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\TypeTask;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour TypeTask.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'TypeTask',
    stateOptions: new Options(entityClass: TypeTask::class),
)]
#[Map(source: TypeTask::class)]
final class TypeTaskResponseDto
{
    #[Groups(['TypeTask:read'])]
    public int $id;

    #[Groups(['TypeTask:read'])]
    public string $name;

    #[Groups(['TypeTask:read'])]
    public ?string $color;

    #[Groups(['TypeTask:read'])]
    public string $pathFileScript;

    #[Groups(['TypeTask:read'])]
    public string $description;

    #[Groups(['TypeTask:read'])]
    public bool $automatique;

    #[Groups(['TypeTask:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['TypeTask:read'])]
    public ?\DateTimeInterface $updatedAt;
}
