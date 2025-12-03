<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskInstanceCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public DateTimeInterface $startDate,

        #[Assert\NotNull]
        public DateTimeInterface $dueDate,

        #[Assert\NotNull]
        public int $order,
    ) {
    }
}
