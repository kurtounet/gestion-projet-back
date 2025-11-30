<?php

declare(strict_types=1);

namespace App\Dto\TypeTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TypeTaskUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $codeId = null,

        #[Assert\Length(max: 100)]
        public ?string $name = null,

        #[Assert\Length(max: 255)]
        public ?string $pathFileScript = null,

        public ?string $description = null,

        public ?bool $automatique = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
