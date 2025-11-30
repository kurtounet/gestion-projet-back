<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplateSprintTemplate;

use DateTimeInterface;
final class ProjectTemplateSprintTemplateResponseDto
{
    public function __construct(
        public int $id,

        public int $projectTemplateId,

        public int $sprintTemplateId,

        public int $sprintOrder,

        public DateTimeInterface $createdAt,

        public DateTimeInterface $updatedAt,
    ) {
    }
}
