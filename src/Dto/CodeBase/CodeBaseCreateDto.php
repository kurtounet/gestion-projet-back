<?php

declare(strict_types=1);

namespace App\Dto\CodeBase;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CodeBaseCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $label,

        #[Assert\NotBlank]
        public string $code,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $pathFile,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $feature,
    ) {
    }
}
