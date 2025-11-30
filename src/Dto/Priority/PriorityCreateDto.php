<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PriorityCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $priorityId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $priorityLabel,

        #[Assert\NotNull]
        public int $priorityNumber,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
