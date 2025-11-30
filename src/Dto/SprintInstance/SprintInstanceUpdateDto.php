<?php

declare(strict_types=1);

namespace App\Dto\SprintInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintInstanceUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $projectInstanceId = null,

        public ?int $priorityId = null,

        public ?int $sprintTemplateId = null,

        public ?int $sprintDependencyId = null,

        #[Assert\Length(max: 100, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $name = null,

        public ?DateTimeInterface $startDate = null,

        public ?DateTimeInterface $endDate = null,

        public ?int $statusId = null,

        public ?int $order = null,

        public ?int $commentId = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
