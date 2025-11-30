<?php

declare(strict_types=1);

namespace App\Dto\ContextStatus;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContextStatusCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du contexte ne doit pas être nul.')]
        public int $contextId,

        #[Assert\NotBlank(message: 'L\'identifiant du statut ne doit pas être vide.')]
        public string $statusId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
