<?php

namespace App\ApiResource\State\Priority;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Priority\PriorityMapper;
use App\Entity\Priority;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class PriorityCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private PriorityMapper $priorityMapper,
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
            if (! $entity instanceof Priority) {
                continue;
            }
            $items[] = $this->priorityMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
