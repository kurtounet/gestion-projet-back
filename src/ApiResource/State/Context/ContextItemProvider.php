<?php

namespace App\ApiResource\State\Context;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Context\ContextMapper;
use App\Entity\Context;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ContextItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ContextMapper $contextMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Context) {
            return $entity;
        }

        return $this->contextMapper->entityToItemDto($entity);
    }
}
