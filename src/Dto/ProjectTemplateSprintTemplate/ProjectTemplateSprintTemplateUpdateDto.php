<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplateSprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateSprintTemplateUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $sprintOrder = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
