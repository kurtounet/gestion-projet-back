<?php

declare(strict_types=1);

namespace App\Dto\ProjectInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectInstanceCreateDto
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
        public DateTimeInterface $endDate,
    ) {
    }
}
