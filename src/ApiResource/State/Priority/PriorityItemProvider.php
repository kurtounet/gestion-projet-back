<?php

namespace App\ApiResource\State\Priority;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Priority\PriorityMapper;
use App\Entity\Priority;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class PriorityItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private PriorityMapper $priorityMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Priority) {
            return $entity;
        }

        return $this->priorityMapper->entityToItemDto($entity);
    }
}
