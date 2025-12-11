<?php

namespace App\Security\Voter;

use App\Entity\ProjectInstance;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class ProjectInstanceVoter extends Voter
{
    public const CREATE = 'PROJECT_INSTANCE_CREATE';
    public const VIEW   = 'PROJECT_INSTANCE_VIEW';
    public const EDIT   = 'PROJECT_INSTANCE_EDIT';
    public const DELETE = 'PROJECT_INSTANCE_DELETE';

    /**
     * Vérifie si ce voter supporte l’attribut et le subject.
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Pour CREATE, il n’y a pas encore de subject
        if ($attribute === self::CREATE) {
            return true;
        }

        // Pour les autres actions, il faut un ProjectInstance
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE], true)
            && $subject instanceof ProjectInstance;
    }

    /**
     * Logique métier d'autorisation
     */
    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
        ?Vote $vote = null
    ): bool {
        $user = $token->getUser();

        // Utilisateur non connecté
        if (!$user instanceof UserInterface) {
            $vote?->addReason('User is not authenticated.');
            return false;
        }

        // CREATE : toute personne authentifiée peut créer
        if ($attribute === self::CREATE) {
            return true;
        }

        /** @var ProjectInstance $project */
        $project = $subject;

        // Règle métier : seul le propriétaire peut VIEW / EDIT / DELETE
        if ($project->getUser() === $user) {
            return true;
        }

        $vote?->addReason('User is not the owner of this ProjectInstance.');
        return false;
    }
}
