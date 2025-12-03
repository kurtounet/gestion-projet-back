<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplateSprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateSprintTemplateCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $sprintOrder,
    ) {
    }
}
