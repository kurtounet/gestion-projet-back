<?php

namespace App\ApiResource\State\TaskTemplate;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TaskTemplate\TaskTemplateMapper;
use App\Entity\TaskTemplate;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TaskTemplateCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private TaskTemplateMapper $taskTemplateMapper
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

            if (! $entity instanceof TaskTemplate) {
                continue;
            }
            $items[] = $this->taskTemplateMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
