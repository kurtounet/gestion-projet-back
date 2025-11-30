<?php

declare(strict_types=1);

namespace App\Dto\TaskInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskInstanceCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant de l\'utilisateur ne doit pas être nul.')]
        public int $userId,

        #[Assert\NotNull(message: 'L\'identifiant du modèle de tâche ne doit pas être nul.')]
        public int $taskTemplateId,

        #[Assert\NotNull(message: 'L\'identifiant de l\'instance de sprint ne doit pas être nul.')]
        public int $sprintInstanceId,

        #[Assert\NotNull(message: 'L\'identifiant de la priorité ne doit pas être nul.')]
        public int $priorityId,

        #[Assert\NotNull(message: 'L\'identifiant du statut ne doit pas être nul.')]
        public int $statusId,

        #[Assert\NotNull(message: 'L\'identifiant du type de tâche ne doit pas être nul.')]
        public int $typeTaskId,

        #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public string $name,

        #[Assert\NotBlank(message: 'La description ne doit pas être vide.')]
        public string $description,

        #[Assert\NotNull(message: 'La date de début ne doit pas être nulle.')]
        public DateTimeInterface $startDate,

        #[Assert\NotNull(message: 'La date d\'échéance ne doit pas être nulle.')]
        public DateTimeInterface $dueDate,

        #[Assert\NotNull(message: 'L\'ordre ne doit pas être nul.')]
        public int $order,

        #[Assert\NotNull(message: 'La tâche parente ne doit pas être nulle.')]
        public int $parentTask,

        #[Assert\NotNull(message: 'L\'identifiant de la dépendance ne doit pas être nul.')]
        public int $dependencyId,

        #[Assert\NotNull(message: 'L\'identifiant du commentaire ne doit pas être nul.')]
        public int $commentId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
