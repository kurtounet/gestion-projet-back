<?php

declare(strict_types=1);

namespace App\Dto\ProjectInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectInstanceCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du statut ne doit pas être nul.')]
        public int $statusId,

        #[Assert\NotNull(message: 'L\'identifiant de la priorité ne doit pas être nul.')]
        public int $priorityId,

        #[Assert\NotNull(message: 'L\'identifiant du modèle de projet ne doit pas être nul.')]
        public int $projectTemplateId,

        #[Assert\NotNull(message: 'L\'identifiant du commentaire ne doit pas être nul.')]
        public int $commentId,

        #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public string $name,

        #[Assert\NotBlank(message: 'La description ne doit pas être vide.')]
        public string $description,

        #[Assert\NotNull(message: 'La date de début ne doit pas être nulle.')]
        public DateTimeInterface $startDate,

        #[Assert\NotNull(message: 'La date de fin ne doit pas être nulle.')]
        public DateTimeInterface $endDate,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
