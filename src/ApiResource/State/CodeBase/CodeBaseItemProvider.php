<?php

namespace App\ApiResource\State\CodeBase;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\CodeBase\CodeBaseMapper;
use App\Entity\CodeBase;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CodeBaseItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private CodeBaseMapper $codeBaseMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (! $entity instanceof CodeBase) {
            return $entity;
        }

        return $this->codeBaseMapper->entityToItemDto($entity);
    }
}
