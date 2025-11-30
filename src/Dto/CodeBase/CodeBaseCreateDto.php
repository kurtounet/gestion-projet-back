<?php

declare(strict_types=1);

namespace App\Dto\CodeBase;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CodeBaseCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le libellé ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le libellé ne doit pas dépasser {{ limit }} caractères.')]
        public string $label,

        #[Assert\NotBlank(message: 'Le code ne doit pas être vide.')]
        public string $code,

        #[Assert\NotBlank(message: 'Le chemin du fichier ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le chemin du fichier ne doit pas dépasser {{ limit }} caractères.')]
        public string $pathFile,

        #[Assert\NotBlank(message: 'La fonctionnalité ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'La fonctionnalité ne doit pas dépasser {{ limit }} caractères.')]
        public string $feature,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
