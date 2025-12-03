<?php

declare(strict_types=1);

namespace App\Dto\SprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTemplateCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public int $duration,
    ) {
    }
}
