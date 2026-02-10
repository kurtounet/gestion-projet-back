<?php

namespace App\Security\Voter;

use App\Entity\TaskInstance;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TaskInstanceVoter extends Voter
{
    public const CREATE = 'TASK_CREATE';
    public const VIEW = 'TASK_VIEW';
    public const EDIT = 'TASK_EDIT';
    public const DELETE = 'TASK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::CREATE, self::EDIT, self::DELETE, self::VIEW])
            && $subject instanceof TaskInstance;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (! $user instanceof UserInterface) {
            $vote?->addReason('The user is not logged in.');

            return false;
        }
        $task = $subject;

        if ($user === $task->getUser()) {
            return true;
        }

        $vote?->addReason('The user is not Owner of the task.');

        return false;
    }
}
