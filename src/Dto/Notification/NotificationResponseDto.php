<?php

declare(strict_types=1);

namespace App\Dto\Notification;

use DateTimeInterface;

final class NotificationResponseDto
{
    public function __construct(
        public int $id,

        public int $userId,

        public string $message,

        public DateTimeInterface $date,

        public string $type,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {}
}
