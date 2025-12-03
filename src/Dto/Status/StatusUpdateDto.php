<?php

declare(strict_types=1);

namespace App\Dto\Status;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StatusUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 50)]
        public ?string $label = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
