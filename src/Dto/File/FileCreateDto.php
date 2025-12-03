<?php

declare(strict_types=1);

namespace App\Dto\File;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FileCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $path,

        #[Assert\NotBlank]
        public string $keyWord,
    ) {
    }
}
