<?php

declare(strict_types=1);

namespace App\Dto\Status;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StatusCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du statut ne doit pas être nul.')]
        public int $statusId,

        #[Assert\NotBlank(message: 'Le nom du statut ne doit pas être vide.')]
        #[Assert\Length(max: 50, maxMessage: 'Le nom du statut ne doit pas dépasser {{ limit }} caractères.')]
        public string $statusName,

        #[Assert\NotNull(message: 'Le contexte du statut ne doit pas être nul.')]
        public int $statusContext,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
