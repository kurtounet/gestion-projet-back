<?php

namespace App\ApiResource\State\TaskInstance;

use App\Entity\TaskInstance;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TaskInstance\TaskInstanceMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TaskInstanceItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private TaskInstanceMapper $taskInstanceMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof TaskInstance) {
            return $entity;
        }

        return $this->taskInstanceMapper->entityToItemDto($entity);
    }
}