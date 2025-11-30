<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateCreateDto
{
    public function __construct(

        #[Assert\NotBlank(message: 'Ce Champ est obligatoire')]
        #[Assert\Length(
            min: 3,
            minMessage: 'Le nom doit avoir au moins {{ limit }} caractères',
            max: 255,
            maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères',
        )]
        public string $name,

        #[Assert\NotBlank(message: 'Ce Champ est obligatoire')]
        public string $description,

        #[Assert\NotBlank(message: 'Ce Champ est obligatoire')]
        public DateTimeInterface $duration,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {}
}
