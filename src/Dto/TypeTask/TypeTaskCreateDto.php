<?php

declare(strict_types=1);

namespace App\Dto\TypeTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TypeTaskCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $codeId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $pathFileScript,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public bool $automatique,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
