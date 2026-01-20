<?php

namespace App\ApiResource\State\Framework;

use App\Entity\Framework;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Framework\FrameworkMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FrameworkItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private FrameworkMapper $frameworkMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Framework) {
            return $entity;
        }

        return $this->frameworkMapper->entityToItemDto($entity);
    }
}