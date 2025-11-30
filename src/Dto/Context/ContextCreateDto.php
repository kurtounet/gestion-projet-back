<?php

declare(strict_types=1);

namespace App\Dto\Context;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContextCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le libellé du contexte ne doit pas être vide.')]
        #[Assert\Length(max: 50, maxMessage: 'Le libellé du contexte ne doit pas dépasser {{ limit }} caractères.')]
        public string $contextLabel,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
