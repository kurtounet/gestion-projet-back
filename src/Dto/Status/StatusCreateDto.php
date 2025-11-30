<?php

declare(strict_types=1);

namespace App\Dto\Status;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StatusCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $statusId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $statusName,

        #[Assert\NotNull]
        public int $statusContext,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
