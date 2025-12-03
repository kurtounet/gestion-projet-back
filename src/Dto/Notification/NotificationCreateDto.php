<?php

declare(strict_types=1);

namespace App\Dto\Notification;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class NotificationCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $message,

        #[Assert\NotNull]
        public DateTimeInterface $date,

        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $type,
    ) {
    }
}
