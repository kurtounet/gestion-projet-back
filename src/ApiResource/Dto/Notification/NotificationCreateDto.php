<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Notification.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
#[Map(target: Notification::class)]
final class NotificationCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['Notification:create'])]
    public string $message;

    #[Assert\NotBlank]
    #[Groups(['Notification:create'])]
    public \DateTimeInterface $date;

    #[Assert\NotBlank]
    #[Groups(['Notification:create'])]
    public string $type;

    #[Assert\NotBlank]
    #[Groups(['Notification:create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['Notification:create'])]
    public ?\DateTimeInterface $updatedAt;



    #[Groups(['Notification:create'])]
    public ?string $user;
}
