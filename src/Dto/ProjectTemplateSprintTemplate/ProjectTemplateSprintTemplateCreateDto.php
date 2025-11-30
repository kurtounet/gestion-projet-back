<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplateSprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateSprintTemplateCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $projectTemplateId,

        #[Assert\NotNull]
        public int $sprintTemplateId,

        #[Assert\NotNull]
        public int $sprintOrder,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
