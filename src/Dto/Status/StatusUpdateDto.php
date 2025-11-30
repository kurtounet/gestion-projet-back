<?php

declare(strict_types=1);

namespace App\Dto\Status;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StatusUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $statusId = null,

        #[Assert\Length(max: 50, maxMessage: 'Le nom du statut ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $statusName = null,

        public ?int $statusContext = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
