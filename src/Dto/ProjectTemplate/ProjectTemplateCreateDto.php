<?php

declare(strict_types=1);

namespace App\Dto\ProjectTemplate;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProjectTemplateCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $description,

        #[Assert\NotNull]
        public int $duration,
    ) {
    }
}
