<?php

declare(strict_types=1);

namespace App\Dto\SprintTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTemplateUpdateDto
{
    public function __construct(
        public ?int $id = null,

        public ?int $sprintTemplateId = null,

        #[Assert\Length(max: 255, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
        public ?string $name = null,

        public ?string $description = null,

        public ?int $duration = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
