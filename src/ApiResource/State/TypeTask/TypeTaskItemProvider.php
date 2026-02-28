<?php

namespace App\ApiResource\State\TypeTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TypeTask\TypeTaskMapper;
use App\Entity\TypeTask;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TypeTaskItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private TypeTaskMapper $typeTaskMapper
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (! $entity instanceof TypeTask) {
            return $entity;
        }

        return $this->typeTaskMapper->entityToItemDto($entity);
    }
}
