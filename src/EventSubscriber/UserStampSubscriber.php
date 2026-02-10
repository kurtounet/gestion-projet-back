<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\Event\PreUpdateEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

final class UserStampSubscriber implements EventSubscriber
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $userIdentifier = $this->getUserIdentifier();

        if (! $userIdentifier) {
            return;
        }

        // On ne touche que les entités qui exposent ces méthodes
        if (method_exists($entity, 'setCreatedByUser') && method_exists($entity, 'setUpdatedByUser')) {
            if (method_exists($entity, 'getCreatedByUser') && null === $entity->getCreatedByUser()) {
                $entity->setCreatedByUser($userIdentifier);
            }

            $entity->setUpdatedByUser($userIdentifier);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $userIdentifier = $this->getUserIdentifier();

        if (! $userIdentifier) {
            return;
        }

        if (method_exists($entity, 'setUpdatedByUser')) {
            $entity->setUpdatedByUser($userIdentifier);
        }

        // Important pour notifier Doctrine que le champ a changé
        if (method_exists($entity, 'setCreatedByUser') && method_exists($entity, 'setUpdatedByUser')) {
            if (method_exists($entity, 'getCreatedByUser') && null === $entity->getCreatedByUser()) {
                $entity->setCreatedByUser($userIdentifier);
            }

            $entity->setUpdatedByUser($userIdentifier);
        }
    }

    private function getUserIdentifier(): ?string
    {
        $user = $this->security->getUser();

        if (! $user instanceof User) {
            return null;
        }

        return $user->getUserIdentifier();
    }
}
