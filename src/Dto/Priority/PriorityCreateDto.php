<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PriorityCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $label,

        #[Assert\NotNull]
        public int $priorityNumber,
    ) {
    }
}
