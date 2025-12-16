<?php

namespace App\ApiResource\Resource\SprintInstance;



use App\Entity\Priority;
use App\Entity\SprintTemplate;
use App\Entity\Status;
use App\Entity\Comment;
use App\Entity\SprintInstance;
use App\Entity\ProjectInstance;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\SprintInstance\SprintInstanceCreateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceUpdateDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceResponseDto;
use App\ApiResource\Dto\SprintInstance\SprintInstanceCollectionResponse;

use App\ApiResource\State\SprintInstance\SprintInstanceProvider;
use App\ApiResource\State\SprintInstance\SprintInstanceProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'SprintInstance',
    stateOptions: new Options(entityClass: SprintInstance::class),
    operations: [
        new GetCollection(
            // security: "is_granted('SPRINT_INSTANCE_LIST', object)",
            // normalizationContext: ['groups' => ['SprintInstance:collection:read']],
            // provider: SprintInstanceProvider::class,
            // output: SprintInstanceCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('SPRINT_INSTANCE_VIEW', object)",
            // normalizationContext: ['groups' => ['SprintInstance:item:read']],
            // provider: SprintInstanceProvider::class,
            // output: SprintInstanceResponseDto::class
        ),
        new Post(
            // security: "is_granted('SPRINT_INSTANCE_CREATE', object)",
            // denormalizationContext: ['groups' => ['SprintInstance:create']],
            // processor: SprintInstanceProcessor::class,
            // input: SprintInstanceCreateDto::class
        ),
        new Patch(
            // security: "is_granted('SPRINT_INSTANCE_EDIT', object)",
            // denormalizationContext: ['groups' => ['SprintInstance:update']],
            // processor: SprintInstanceProcessor::class,
            // input:SprintInstanceeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('SPRINT_INSTANCE_DELETE', object)",
            // processor: SprintInstanceProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour SprintInstance.
 * Utilisé pour exposer SprintInstance.
 */
#[Map(source: SprintInstance::class)]
final class SprintInstanceResource
{
    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public int $id;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $name;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $description;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $icon;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public string $color;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $startDate;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $endDate;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?int $position;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $createdByUser;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?string $updatedByUser;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?Priority $priority;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?SprintTemplate $sprintTemplate;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?Status $status;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?Comment $comment;

    #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    public ?SprintInstance $sprintDependency;

    // #[Groups(['SprintInstance:collection:read', 'SprintInstance:item:read'])]
    // public ?ProjectInstance $projectInstance;
}
