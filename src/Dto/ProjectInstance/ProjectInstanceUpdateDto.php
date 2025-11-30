<?php

declare(strict_types=1);

namespace App\Dto\ProjectInstance;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectInstanceUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $statusId = null,

        public ?int $priorityId = null,

        public ?int $projectTemplateId = null,

        public ?int $commentId = null,

        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $name = null,

        public ?string $description = null,

        public ?DateTimeInterface $startDate = null,

        public ?DateTimeInterface $endDate = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
