<?php

namespace App\ApiResource\Resource\Notification;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Notification\NotificationCreateDto;
use App\ApiResource\Dto\Notification\NotificationUpdateDto;
use App\ApiResource\State\Notification\NotificationCollectionProvider;
use App\ApiResource\State\Notification\NotificationCreateProcessor;
use App\ApiResource\State\Notification\NotificationDeleteProcessor;
use App\ApiResource\State\Notification\NotificationItemProvider;
use App\ApiResource\State\Notification\NotificationUpdateProcessor;
use App\Entity\Notification;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Notification',
    stateOptions: new Options(entityClass: Notification::class),
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:read']],
            provider: NotificationCollectionProvider::class,
            output: self::class
        ),
        new Get(
            normalizationContext: ['groups' => ['item:read']],
            provider: NotificationItemProvider::class,
            output: self::class
        ),
        new Post(
            denormalizationContext: ['groups' => ['create']],
            processor: NotificationCreateProcessor::class,
            input: NotificationCreateDto::class,
            output: self::class
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update']],
            processor: NotificationUpdateProcessor::class,
            input: NotificationUpdateDto::class,
            output: self::class
        ),
        new Delete(
            processor: NotificationDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]

final class NotificationResource
{
    #[ApiProperty(identifier: true)]
    #[Groups(['collection:read', 'item:read'])]
    public int $id;

    #[Groups(['collection:read', 'item:read'])]
    public string $message;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $date;

    #[Groups(['collection:read', 'item:read'])]
    public string $type;

    #[Groups(['collection:read', 'item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['collection:read', 'item:read'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['collection:read', 'item:read'])]
    public ?string $user = null;


}
