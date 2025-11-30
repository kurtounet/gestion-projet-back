<?php

declare(strict_types=1);

namespace App\Dto\TypeTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TypeTaskCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du code ne doit pas être nul.')]
        public int $codeId,

        #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
        #[Assert\Length(max: 100, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public string $name,

        #[Assert\NotBlank(message: 'Le chemin du fichier de script ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le chemin du fichier de script ne doit pas dépasser {{ limit }} caractères.')]
        public string $pathFileScript,

        #[Assert\NotBlank(message: 'La description ne doit pas être vide.')]
        public string $description,

        #[Assert\NotNull(message: 'Le champ automatique ne doit pas être nul.')]
        public bool $automatique,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
