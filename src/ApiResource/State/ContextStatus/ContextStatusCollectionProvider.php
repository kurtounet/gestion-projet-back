<?php

namespace App\ApiResource\State\ContextStatus;

use App\Entity\ContextStatus;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\ApiResource\Mapper\ContextStatus\ContextStatusMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final readonly class ContextStatusCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ContextStatusMapper $contextStatusMapper
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!($operation instanceof CollectionOperationInterface)) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {

            if (!$entity instanceof ContextStatus) {
                continue;
            }
            $items[] = $this->contextStatusMapper->entityToCollectionDto($entity);
        }
        return $items;
    }
}