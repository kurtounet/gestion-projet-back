<?php

namespace App\ApiResource\State\Notification;

use App\Entity\Notification;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Notification\NotificationMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class NotificationItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private NotificationMapper $notificationMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Notification) {
            return $entity;
        }

        return $this->notificationMapper->entityToItemDto($entity);
    }
}