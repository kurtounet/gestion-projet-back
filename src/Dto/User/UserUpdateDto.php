<?php

declare(strict_types=1);

namespace App\Dto\User;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class UserUpdateDto
{
    public function __construct(
        public ?int $id = null,

        #[Assert\Length(max: 180)]
        public ?string $email = null,

        public ?array $roles = null,

        public ?string $password = null,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
