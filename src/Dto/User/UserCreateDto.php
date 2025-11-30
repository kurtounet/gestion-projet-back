<?php

declare(strict_types=1);

namespace App\Dto\User;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class UserCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 180)]
        public string $email,

        #[Assert\NotNull]
        public array $roles,

        #[Assert\NotBlank]
        public string $password,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
