<?php

declare(strict_types=1);

namespace App\Dto\Feature;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class FeatureUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 255)]
        public ?string $label = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
