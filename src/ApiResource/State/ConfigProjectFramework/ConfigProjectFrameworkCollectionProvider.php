<?php

namespace App\ApiResource\State\ConfigProjectFramework;

use App\Entity\ConfigProjectFramework;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\ApiResource\Mapper\ConfigProjectFramework\ConfigProjectFrameworkMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final readonly class ConfigProjectFrameworkCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ConfigProjectFrameworkMapper $configProjectFrameworkMapper
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!($operation instanceof CollectionOperationInterface)) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {

            if (!$entity instanceof ConfigProjectFramework) {
                continue;
            }
            $items[] = $this->configProjectFrameworkMapper->entityToCollectionDto($entity);
        }
        return $items;
    }
}