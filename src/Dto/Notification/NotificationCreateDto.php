<?php

declare(strict_types=1);

namespace App\Dto\Notification;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class NotificationCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant de l\'utilisateur ne doit pas être nul.')]
        public int $userId,

        #[Assert\NotBlank(message: 'Le message ne doit pas être vide.')]
        public string $message,

        #[Assert\NotNull(message: 'La date ne doit pas être nulle.')]
        public DateTimeInterface $date,

        #[Assert\NotBlank(message: 'Le type ne doit pas être vide.')]
        #[Assert\Length(max: 50, maxMessage: 'Le type ne doit pas dépasser {{ limit }} caractères.')]
        public string $type,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {}
}
