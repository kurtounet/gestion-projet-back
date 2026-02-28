<?php

namespace App\ApiResource\Dto\Notification;

use App\Entity\Notification;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO de création pour Notification.
 * Input POST.
 *
 * Relations ToOne attendues en IRI string (ex: "/api/statuses/1").
 */
final class NotificationCreateDto
{
    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $message;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $date;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public string $type;

    #[Assert\NotBlank]
    #[Groups(['create'])]
    public \DateTimeInterface $createdAt;

    #[Groups(['create'])]
    public ?\DateTimeInterface $updatedAt = null;



    #[Groups(['create'])]
    public ?string $user = null;
}
