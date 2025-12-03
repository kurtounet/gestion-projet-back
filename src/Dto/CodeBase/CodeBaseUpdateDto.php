<?php

declare(strict_types=1);

namespace App\Dto\CodeBase;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CodeBaseUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $label = null,

        public ?string $code = null,

        #[Assert\Length(max: 255)]
        public ?string $pathFile = null,

        #[Assert\Length(max: 255)]
        public ?string $feature = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
