<?php

declare(strict_types=1);

namespace App\Dto\TaskTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskTemplateCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du modèle de sprint ne doit pas être nul.')]
        public int $sprintTemplateId,

        #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public string $name,

        #[Assert\NotBlank(message: 'La description ne doit pas être vide.')]
        public string $description,

        #[Assert\NotNull(message: 'La tâche parente ne doit pas être nulle.')]
        public int $parentTask,

        #[Assert\NotNull(message: 'L\'identifiant du type de tâche ne doit pas être nul.')]
        public int $typeTaskId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
