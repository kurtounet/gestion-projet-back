<?php

declare(strict_types=1);

namespace App\Dto\TaskTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TaskTemplateUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $name = null,

        public ?string $description = null,

        public ?int $parentTask = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
