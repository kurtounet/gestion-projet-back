<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplateSprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateSprintTemplateCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant du modèle de projet ne doit pas être nul.')]
        public int $projectTemplateId,

        #[Assert\NotNull(message: 'L\'identifiant du modèle de sprint ne doit pas être nul.')]
        public int $sprintTemplateId,

        #[Assert\NotNull(message: 'L\'ordre du sprint ne doit pas être nul.')]
        public int $sprintOrder,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
