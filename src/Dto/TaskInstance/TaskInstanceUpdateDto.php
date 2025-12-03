<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskInstanceUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $name = null,

        public ?string $description = null,

        public ?DateTimeInterface $startDate = null,

        public ?DateTimeInterface $dueDate = null,

        public ?int $order = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
