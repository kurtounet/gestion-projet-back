<?php

declare(strict_types=1);

namespace App\Dto\File;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FileUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $path = null,

        public ?string $keyWord = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
