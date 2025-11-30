<?php

declare(strict_types=1);

namespace App\Dto\Priority;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PriorityCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant de la priorité ne doit pas être nul.')]
        public int $priorityId,

        #[Assert\NotBlank(message: 'Le libellé de la priorité ne doit pas être vide.')]
        #[Assert\Length(max: 50, maxMessage: 'Le libellé de la priorité ne doit pas dépasser {{ limit }} caractères.')]
        public string $priorityLabel,

        #[Assert\NotNull(message: 'Le numéro de la priorité ne doit pas être nul.')]
        public int $priorityNumber,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
