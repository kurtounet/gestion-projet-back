<?php

namespace App\ApiResource\State\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ConfigProjectFramework\ConfigProjectFrameworkMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ConfigProjectFrameworkItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ConfigProjectFrameworkMapper $configProjectFrameworkMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ConfigProjectFramework) {
            return $entity;
        }

        return $this->configProjectFrameworkMapper->entityToItemDto($entity);
    }
}