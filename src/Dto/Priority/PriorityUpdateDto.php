<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PriorityUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $priorityId = null,

        #[Assert\Length(max: 50)]
        public ?string $priorityLabel = null,

        public ?int $priorityNumber = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
