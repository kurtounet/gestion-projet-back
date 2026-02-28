<?php

namespace App\ApiResource\State\TypeTask;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TypeTask\TypeTaskMapper;
use App\Entity\TypeTask;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TypeTaskCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private TypeTaskMapper $typeTaskMapper
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

            if (! $entity instanceof TypeTask) {
                continue;
            }
            $items[] = $this->typeTaskMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
