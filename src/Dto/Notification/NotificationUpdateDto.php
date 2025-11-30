<?php

declare(strict_types=1);

namespace App\Dto\Notification;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class NotificationUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $userId = null,

        public ?string $message = null,

        public ?DateTimeInterface $date = null,

        #[Assert\Length(max: 50)]
        public ?string $type = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {}
}
