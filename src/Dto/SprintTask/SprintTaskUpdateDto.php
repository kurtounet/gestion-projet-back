<?php

declare(strict_types=1);

namespace App\Dto\SprintTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTaskUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $sprintTemplateId = null,

        public ?int $taskTemplateId = null,

        public ?int $taskOrder = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
