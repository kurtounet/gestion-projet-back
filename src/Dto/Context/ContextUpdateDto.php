<?php

declare(strict_types=1);

namespace App\Dto\Context;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContextUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 50)]
        public ?string $contextLabel = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
