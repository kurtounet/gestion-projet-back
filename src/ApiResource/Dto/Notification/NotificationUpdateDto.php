<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Notification.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Notification::class)]
final class NotificationUpdateDto
{
    #[Groups(['Notification:update'])]
    public ?string $message;

    #[Groups(['Notification:update'])]
    public ?\DateTimeInterface $date;

    #[Groups(['Notification:update'])]
    public ?string $type;

    #[Groups(['Notification:update'])]
    public ?\DateTimeInterface $createdAt;

    #[Groups(['Notification:update'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Notification:update'])]
    public ?string $user;
}
