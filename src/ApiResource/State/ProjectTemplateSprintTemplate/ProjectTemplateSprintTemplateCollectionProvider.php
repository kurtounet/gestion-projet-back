<?php

namespace App\ApiResource\State\ProjectTemplateSprintTemplate;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ProjectTemplateSprintTemplate\ProjectTemplateSprintTemplateMapper;
use App\Entity\ProjectTemplateSprintTemplate;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectTemplateSprintTemplateCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ProjectTemplateSprintTemplateMapper $projectTemplateSprintTemplateMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            throw new \LogicException(sprintf('%s ne gère que les opérations de collection.', self::class));
        }

        $result = $this->collectionProvider->provide($operation, $uriVariables, $context);
        if (!is_iterable($result)) {
            return $result;
        }

        $items = [];
        foreach ($result as $entity) {
            if (!$entity instanceof ProjectTemplateSprintTemplate) {
                continue;
            }
            $items[] = $this->projectTemplateSprintTemplateMapper->entityToCollectionDto($entity);
        }

        return $items;
    }
}
