<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de mise à jour partielle pour Notification.
 * Input PATCH.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class NotificationUpdateDto
{
    #[Groups(['update'])]
    public ?string $message = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $date = null;

    #[Groups(['update'])]
    public ?string $type = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups(['update'])]
    public ?\DateTimeInterface $updatedAt = null;

    #[Groups(['update'])]
    public ?string $user = null;
}
