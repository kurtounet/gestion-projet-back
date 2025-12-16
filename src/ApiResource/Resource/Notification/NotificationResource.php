<?php

namespace App\ApiResource\Resource\Notification;

use App\Entity\Notification;

use App\Entity\User;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\State\Options;

use App\ApiResource\Dto\Notification\NotificationCreateDto;
use App\ApiResource\Dto\Notification\NotificationUpdateDto;
use App\ApiResource\Dto\Notification\NotificationResponseDto;
use App\ApiResource\Dto\Notification\NotificationCollectionResponse;

use App\ApiResource\State\Notification\NotificationProvider;
use App\ApiResource\State\Notification\NotificationProcessor;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Notification',
    stateOptions: new Options(entityClass: Notification::class),
    operations: [
        new GetCollection(
            // security: "is_granted('NOTIFICATION_LIST', object)",
            // normalizationContext: ['groups' => ['Notification:collection:read']],
            // provider: NotificationProvider::class,
            // output: NotificationCollectionResponse::class
        ),
        new Get(
            // security: "is_granted('NOTIFICATION_VIEW', object)",
            // normalizationContext: ['groups' => ['Notification:item:read']],
            // provider: NotificationProvider::class,
            // output: NotificationResponseDto::class
        ),
        new Post(
            // security: "is_granted('NOTIFICATION_CREATE', object)",
            // denormalizationContext: ['groups' => ['Notification:create']],
            // processor: NotificationProcessor::class,
            // input: NotificationCreateDto::class
        ),
        new Patch(
            // security: "is_granted('NOTIFICATION_EDIT', object)",
            // denormalizationContext: ['groups' => ['Notification:update']],
            // processor: NotificationProcessor::class,
            // input:NotificationeUpdateDto::class
        ),
        new Delete(
            // security: "is_granted('NOTIFICATION_DELETE', object)",
            // processor: NotificationProcessor::class,
            // output: false,
            // status: 204
        ),
    ]
)]

/**
 * DTO resource pour Notification.
 * Utilisé pour exposer Notification.
 */
#[Map(source: Notification::class)]
final class NotificationResource
{
    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public int $id;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public string $message;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public \DateTimeInterface $date;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public string $type;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Notification:collection:read', 'Notification:item:read'])]
    public ?User $user;
}
