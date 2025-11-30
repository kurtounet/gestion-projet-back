<?php

declare(strict_types=1);

namespace App\Dto\SprintTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTaskCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $sprintTemplateId,

        #[Assert\NotNull]
        public int $taskTemplateId,

        #[Assert\NotNull]
        public int $taskOrder,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
