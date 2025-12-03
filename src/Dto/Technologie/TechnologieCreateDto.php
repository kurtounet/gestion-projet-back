<?php

declare(strict_types=1);

namespace App\Dto\Technologie;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TechnologieCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        public string $label,
    ) {
    }
}
