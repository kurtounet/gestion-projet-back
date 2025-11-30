<?php

declare(strict_types=1);

namespace App\Dto\ContextStatus;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContextStatusCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $contextId,

        #[Assert\NotBlank]
        public string $statusId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
