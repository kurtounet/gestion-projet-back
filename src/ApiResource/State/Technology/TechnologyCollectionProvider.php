<?php

namespace App\ApiResource\State\Technology;

use App\Entity\Technology;
use App\ApiResource\Dto\Technology\TechnologyCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\ApiResource\Resource\Framework\FrameworkResource;

final readonly class TechnologyCollectionProvider implements ProviderInterface
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
            if (!$entity instanceof Technology) {
                continue;
            }

            $dto = new TechnologyCollectionItemDto();

        // 1) Scalars
        $dto->id = $entity->getId();
        $dto->label = $entity->getLabel();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

         // 2) Relations ToOne => IRI (si présentes dans le DTO)
/*
        // No ToOne relations


        // 3) Relations ToMany => array of IRIs (si présentes dans le DTO)
        // framework (ToMany => array of IRIs)
        $dto->framework = $this->toIriList($entity->getFramework(), FrameworkResource::class);
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