<?php

declare(strict_types=1);

namespace App\Dto\ContextStatus;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContextStatusUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
