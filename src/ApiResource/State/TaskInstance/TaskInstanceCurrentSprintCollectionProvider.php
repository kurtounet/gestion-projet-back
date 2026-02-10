<?php

namespace App\ApiResource\State\TaskInstance;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TaskInstance\TaskInstanceMapper;
use App\Entity\SprintInstance;
use App\Entity\TaskInstance;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TaskInstanceCurrentSprintCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private TaskInstanceMapper $taskInstanceMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $sprintVar = $uriVariables['sprintId'] ?? null;
        if (null === $sprintVar || '' === $sprintVar) {
            throw new \LogicException('uriVariable "id" est absent.');
        }

        $sprintId = $sprintVar instanceof SprintInstance ? (string) $sprintVar->getId() : (string) $sprintVar;

        $context['filters'] ??= [];
        $context['filters']['sprintInstance.id'] = $sprintId;

        if (!$operation instanceof CollectionOperationInterface) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {
            if (!$entity instanceof TaskInstance) {
                continue;
            }
            $items[] = $this->taskInstanceMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
