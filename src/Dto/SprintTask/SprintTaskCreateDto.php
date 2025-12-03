<?php

declare(strict_types=1);

namespace App\Dto\SprintTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SprintTaskCreateDto
{
    public function __construct(
        #[Assert\NotNull]
        public int $taskOrder,
    ) {
    }
}
