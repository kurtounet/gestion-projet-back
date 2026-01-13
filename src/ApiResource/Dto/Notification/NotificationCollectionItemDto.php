<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Notification::class)]
final class NotificationCollectionItemDto
{
    #[Groups(['Notification:collection:read'])]
    public int $id;

    #[Groups(['Notification:collection:read'])]
    public string $message;

    #[Groups(['Notification:collection:read'])]
    public \DateTimeInterface $date;

    #[Groups(['Notification:collection:read'])]
    public string $type;

    #[Groups(['Notification:collection:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Notification:collection:read'])]
    public ?\DateTimeInterface $updatedAt;
}
