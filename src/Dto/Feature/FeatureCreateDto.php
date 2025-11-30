<?php

declare(strict_types=1);

namespace App\Dto\Feature;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FeatureCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le libellé ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le libellé ne doit pas dépasser {{ limit }} caractères.')]
        public string $label,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
