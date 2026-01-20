<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[Map(source: Notification::class)]
final class NotificationRelationDto
{
    #[Groups(['Notification:relation:read'])]
    public int $id;
}
