<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintInstanceUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 100)]
        public ?string $name = null,

        public ?DateTimeInterface $startDate = null,

        public ?DateTimeInterface $endDate = null,

        public ?int $order = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
