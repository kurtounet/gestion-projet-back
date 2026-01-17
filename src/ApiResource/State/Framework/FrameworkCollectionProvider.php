<?php

namespace App\ApiResource\State\Framework;

use App\Entity\Framework;
use App\ApiResource\Dto\Framework\FrameworkCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\ConfigProjectFramework\ConfigProjectFrameworkResource;
use App\ApiResource\Resource\Technology\TechnologyResource;

final readonly class FrameworkCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private IriFromResource $iriFromResource,
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
            if (!$entity instanceof Framework) {
                continue;
            }

            $dto = new FrameworkCollectionItemDto();

        // 1) Scalars
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->version = $entity->getVersion();
        $dto->configuration = $entity->getConfiguration();
        $dto->icon = $entity->getIcon();
        $dto->color = $entity->getColor();

         // 2) Relations ToOne => IRI (si présentes dans le DTO)
/*
        // technology (ToOne => IRI)
        $dto->technology = $entity->getTechnology()
            ? ($this->iriFromResource)(TechnologyResource::class,$entity->getTechnology()->getId())
            : null;

        // 3) Relations ToMany => array of IRIs (si présentes dans le DTO)
        // configProjectFrameworks (ToMany => array of IRIs)
        $dto->configProjectFrameworks = $this->toIriList($entity->getConfigProjectFrameworks(), ConfigProjectFrameworkResource::class);
*/

            $items[] = $dto;
        }
        return $items;
    }

    private function toIriList(iterable $items, string $resourceClass): array
    {
        $iris = [];

        foreach ($items as $item) {
            if (!is_object($item)) {
                continue;
            }

            $iri = ($this->iriFromResource)($resourceClass, $item->getId());
            if (null !== $iri) {
                $iris[] = $iri;
            }
        }

        return $iris;
    }
}