<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintInstanceCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant de l\'instance de projet ne doit pas être nul.')]
        public int $projectInstanceId,

        #[Assert\NotNull(message: 'L\'identifiant de la priorité ne doit pas être nul.')]
        public int $priorityId,

        #[Assert\NotNull(message: 'L\'identifiant du modèle de sprint ne doit pas être nul.')]
        public int $sprintTemplateId,

        #[Assert\NotNull(message: 'L\'identifiant de la dépendance de sprint ne doit pas être nul.')]
        public int $sprintDependencyId,

        #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
        #[Assert\Length(max: 100, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public string $name,

        #[Assert\NotNull(message: 'La date de début ne doit pas être nulle.')]
        public DateTimeInterface $startDate,

        #[Assert\NotNull(message: 'La date de fin ne doit pas être nulle.')]
        public DateTimeInterface $endDate,

        #[Assert\NotNull(message: 'L\'identifiant du statut ne doit pas être nul.')]
        public int $statusId,

        #[Assert\NotNull(message: 'L\'ordre ne doit pas être nul.')]
        public int $order,

        #[Assert\NotNull(message: 'L\'identifiant du commentaire ne doit pas être nul.')]
        public int $commentId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
