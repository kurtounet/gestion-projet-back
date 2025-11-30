<?php

declare(strict_types=1);

namespace App\Dto\SprintTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTaskCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du modèle de sprint ne doit pas être nul.')]
        public int $sprintTemplateId,

        #[Assert\NotNull(message: 'L\'identifiant du modèle de tâche ne doit pas être nul.')]
        public int $taskTemplateId,

        #[Assert\NotNull(message: 'L\'ordre de la tâche ne doit pas être nul.')]
        public int $taskOrder,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
