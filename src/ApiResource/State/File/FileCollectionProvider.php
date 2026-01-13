<?php

namespace App\ApiResource\State\File;

use App\Entity\File;
use App\ApiResource\Dto\File\FileCollectionItemDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Service\IriFromResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class FileCollectionProvider implements ProviderInterface
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
            if (!$entity instanceof File) {
                continue;
            }

            $dto = new FileCollectionItemDto();

        // 1) Scalars
        $dto->id = $entity->getId();
        $dto->path = $entity->getPath();
        $dto->keyWord = $entity->getKeyWord();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

         // 2) Relations ToOne => IRI (si présentes dans le DTO)
/*
        // No ToOne relations


        // 3) Relations ToMany => array of IRIs (si présentes dans le DTO)
        // No ToMany relations

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