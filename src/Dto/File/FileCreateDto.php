<?php

declare(strict_types=1);

namespace App\Dto\File;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FileCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le chemin ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le chemin ne doit pas dépasser {{ limit }} caractères.')]
        public string $path,

        #[Assert\NotBlank(message: 'Le mot-clé ne doit pas être vide.')]
        public string $keyWord,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
