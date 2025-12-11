<?php

namespace App\ApiResource\Dto\Notification;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * DTO de sortie (Resource) pour Notification.
 * C'est le contrat public exposé par l'API.
 */
#[ApiResource(
    shortName: 'Notification',
    stateOptions: new Options(entityClass: Notification::class),
)]
#[Map(source: Notification::class)]
final class NotificationResponseDto
{
    #[Groups(['Notification:read'])]
    public int $id;

    #[Groups(['Notification:read'])]
    public string $message;

    #[Groups(['Notification:read'])]
    public \DateTimeInterface $date;

    #[Groups(['Notification:read'])]
    public string $type;

    #[Groups(['Notification:read'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Notification:read'])]
    public ?\DateTimeInterface $updatedAt;
}
