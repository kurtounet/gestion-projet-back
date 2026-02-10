<?php

namespace App\ApiResource\State\ContextStatus;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ContextStatus\ContextStatusMapper;
use App\Entity\ContextStatus;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ContextStatusItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ContextStatusMapper $contextStatusMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (! $entity instanceof ContextStatus) {
            return $entity;
        }

        return $this->contextStatusMapper->entityToItemDto($entity);
    }
}
