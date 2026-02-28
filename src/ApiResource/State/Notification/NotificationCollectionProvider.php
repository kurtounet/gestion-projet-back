<?php

namespace App\ApiResource\State\Notification;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Notification\NotificationMapper;
use App\Entity\Notification;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class NotificationCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private NotificationMapper $notificationMapper
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (! $operation instanceof CollectionOperationInterface) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (! is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {

            if (! $entity instanceof Notification) {
                continue;
            }
            $items[] = $this->notificationMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
