<?php

namespace App\ApiResource\Resource\Notification;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Dto\Notification\NotificationCollectionItemDto;
use App\ApiResource\Dto\Notification\NotificationCreateDto;
use App\ApiResource\Dto\Notification\NotificationItemDto;
use App\ApiResource\Dto\Notification\NotificationUpdateDto;
use App\ApiResource\State\Notification\NotificationCollectionProvider;
use App\ApiResource\State\Notification\NotificationCreateProcessor;
use App\ApiResource\State\Notification\NotificationDeleteProcessor;
use App\ApiResource\State\Notification\NotificationItemProvider;
use App\ApiResource\State\Notification\NotificationUpdateProcessor;
use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    shortName: 'Notification',
    stateOptions: new Options(entityClass: Notification::class),
    operations: [
        new GetCollection(
            uriTemplate: 'notifications',
            normalizationContext: ['groups' => ['Notification:collection:read']],
            provider: NotificationCollectionProvider::class,
            output: NotificationCollectionItemDto::class
        ),
        new Get(
            uriTemplate: 'notifications/{id}',
            normalizationContext: ['groups' => ['Notification:item:read']],
            provider: NotificationItemProvider::class,
            output: NotificationItemDto::class
        ),
        new Post(
            uriTemplate: 'notifications',
            denormalizationContext: ['groups' => ['Notification:create']],
            processor: NotificationCreateProcessor::class,
            input: NotificationCreateDto::class,
            output: NotificationItemDto::class
        ),
        new Patch(
            uriTemplate: 'notifications/{id}',
            denormalizationContext: ['groups' => ['Notification:update']],
            processor: NotificationUpdateProcessor::class,
            input: NotificationUpdateDto::class,
            output: NotificationItemDto::class
        ),
        new Delete(
            uriTemplate: 'notifications/{id}',
            processor: NotificationDeleteProcessor::class,
            output: false,
            status: 204
        ),
    ]
)]
// #[Map(source: Notification::class)]
final class NotificationResource
{
    public int $id;
    /*
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
        public ?string $user = null;

    */
}
