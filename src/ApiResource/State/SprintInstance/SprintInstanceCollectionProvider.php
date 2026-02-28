<?php

namespace App\ApiResource\State\SprintInstance;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\SprintInstance\SprintInstanceMapper;
use App\Entity\SprintInstance;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintInstanceCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private SprintInstanceMapper $sprintInstanceMapper
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

            if (! $entity instanceof SprintInstance) {
                continue;
            }
            $items[] = $this->sprintInstanceMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
