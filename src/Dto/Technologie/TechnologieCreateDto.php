<?php

declare(strict_types=1);

namespace App\Dto\Technologie;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TechnologieCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le libellé ne doit pas être vide.')]
        #[Assert\Length(max: 50, maxMessage: 'Le libellé ne doit pas dépasser {{ limit }} caractères.')]
        public string $label,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
