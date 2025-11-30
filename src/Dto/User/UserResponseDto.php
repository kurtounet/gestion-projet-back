<?php

declare(strict_types=1);

namespace App\Dto\User;

use DateTimeInterface;
final class UserResponseDto
{
    public function __construct(
        public int $id,

        public string $email,

        public array $roles,

        public string $password,

        public DateTimeInterface $createdAt,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
