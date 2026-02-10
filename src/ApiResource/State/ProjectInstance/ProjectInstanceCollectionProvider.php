<?php

namespace App\ApiResource\State\ProjectInstance;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ProjectInstance\ProjectInstanceMapper;
use App\Entity\ProjectInstance;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectInstanceCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ProjectInstanceMapper $projectInstanceMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {
            if (!$entity instanceof ProjectInstance) {
                continue;
            }
            $items[] = $this->projectInstanceMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
