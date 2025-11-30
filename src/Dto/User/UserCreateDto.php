<?php

declare(strict_types=1);

namespace App\Dto\User;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class UserCreateDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'L\'email ne doit pas être vide.')]
        #[Assert\Length(max: 180, maxMessage: 'L\'email ne doit pas dépasser {{ limit }} caractères.')]
        public string $email,

        #[Assert\NotNull(message: 'Les rôles ne doivent pas être nuls.')]
        public array $roles,

        #[Assert\NotBlank(message: 'Le mot de passe ne doit pas être vide.')]
        public string $password,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
