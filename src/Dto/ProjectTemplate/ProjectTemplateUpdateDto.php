<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $projectTemplateId = null,

        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $name = null,

        public ?string $description = null,

        public ?DateTimeInterface $duration = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
