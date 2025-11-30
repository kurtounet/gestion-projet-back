<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintInstanceCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $projectInstanceId,

        #[Assert\NotNull]
        public int $priorityId,

        #[Assert\NotNull]
        public int $sprintTemplateId,

        #[Assert\NotNull]
        public int $sprintDependencyId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        public string $name,

        #[Assert\NotNull]
        public DateTimeInterface $startDate,

        #[Assert\NotNull]
        public DateTimeInterface $endDate,

        #[Assert\NotNull]
        public int $statusId,

        #[Assert\NotNull]
        public int $order,

        #[Assert\NotNull]
        public int $commentId,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
