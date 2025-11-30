<?php

declare(strict_types=1);

namespace App\Dto\Technologie;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TechnologieUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 50, maxMessage: 'Le libellé ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $label = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
