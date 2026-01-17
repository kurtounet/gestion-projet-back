<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

//#[Map(source: Notification::class)]
final class NotificationItemDto
{
    #[Groups(['Notification:item:read'])]
    public int $id;

    #[Groups(['Notification:item:read'])]
    public string $message;

    #[Groups(['Notification:item:read'])]
    public \DateTimeInterface $date;

    #[Groups(['Notification:item:read'])]
    public string $type;

    #[Groups(['Notification:item:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Notification:item:read'])]
    public ?\DateTimeInterface $updatedAt;

    #[Groups(['Notification:item:read'])]
    public ?string $user = null;

}
