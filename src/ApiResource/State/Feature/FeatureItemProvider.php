<?php

namespace App\ApiResource\State\Feature;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\Feature\FeatureMapper;
use App\Entity\Feature;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FeatureItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private FeatureMapper $featureMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof Feature) {
            return $entity;
        }

        return $this->featureMapper->entityToItemDto($entity);
    }
}
