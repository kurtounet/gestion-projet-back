<?php

declare(strict_types=1);

namespace App\Dto\Comment;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CommentCreateDto
{
    public function __construct(
        #[Assert\NotNull(message: 'L\'identifiant de la tâche ne doit pas être nul.')]
        public int $taskId,

        #[Assert\NotNull(message: 'L\'identifiant de l\'utilisateur ne doit pas être nul.')]
        public int $userId,

        #[Assert\NotBlank(message: 'Le sujet ne doit pas être vide.')]
        #[Assert\Length(max: 255, maxMessage: 'Le sujet ne doit pas dépasser {{ limit }} caractères.')]
        public string $subject,

        #[Assert\NotBlank(message: 'Le contenu ne doit pas être vide.')]
        public string $content,

        public ?DateTimeInterface $createdAt = null,

        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
