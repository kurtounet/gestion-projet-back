<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\State\Pagination\PaginatorInterface;
use ApiPlatform\State\Pagination\TraversablePaginator;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceResponseDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionItemDto;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceCollectionResponse;
use App\ApiResource\Dto\ProjectInstance\ProjectInstanceItemDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

/**
 * Provider custom pour ProjectInstance.
 * Transforme les entités en DTOs pour la sortie API.
 *
 * @implements ProviderInterface<ProjectInstanceCollectionResponse|ProjectInstanceResponseDto>
 */
final readonly class ProjectInstanceCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,
        private ObjectMapperInterface $objectMapper,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $items = $this->collectionProvider->provide($operation, $uriVariables, $context);

        $items = (function () use ($items, $context) {

            foreach ($items as $entity) {
                \assert($entity instanceof ProjectInstance);
                yield $this->objectMapper->map($entity, ProjectInstanceCollectionItemDto::class, $context);
            }
        })();

        // Conserver la pagination Hydra si paginator

        if ($items instanceof PaginatorInterface) {
            return new TraversablePaginator(
                $items,
                $items->getCurrentPage(),
                $items->getItemsPerPage(),
                $items->getTotalItems()
            );
        }

        return  $items;
    }

    // private function provideCollection(Operation $operation, array $uriVariables, array $context): array
    // {
    //     $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);

    //     $data = [];
    //     foreach ($entities as $entity) {
    //         \assert($entity instanceof ProjectInstance);
    //         $data[] = $this->createCollectionDto($entity);
    //     }

    //     return $data;
    // }

    // private function provideItem(Operation $operation, array $uriVariables, array $context): ?ProjectInstanceResponseDto
    // {
    //     $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

    //     if (!$entity instanceof ProjectInstance) {
    //         return null;
    //     }

    //     return $this->objectMapper->map(
    //         $entity,
    //         ProjectInstanceResponseDto::class
    //     );
    //     // return $this->createItemDto($entity);
    // }

    // private function createCollectionDto(ProjectInstance $entity): ProjectInstanceCollectionResponse
    // {
    //     return new ProjectInstanceCollectionResponse(
    //         id: $entity->getId(),
    //         // name: $entity->getName(),
    //         pathFileDatabase: $entity->getPathFileDatabase(),
    //         pathProject: $entity->getPathProject(),
    //         description: $entity->getDescription(),
    //         icon: $entity->getIcon(),
    //         color: $entity->getColor(),
    //         isFavory: $entity->isFavory(),
    //         position: $entity->getPosition(),
    //         startDate: $entity->getStartDate(),
    //         endDate: $entity->getEndDate(),
    //         createdByUser: $entity->getCreatedByUser(),
    //         updatedByUser: $entity->getUpdatedByUser(),
    //         createdAt: $entity->getCreatedAt(),
    //         updatedAt: $entity->getUpdatedAt()
    //     );
    // }

    // private function createItemDto(ProjectInstance $entity): ProjectInstanceResponseDto
    // {
    //     return new ProjectInstanceResponseDto(
    //         id: $entity->getId(),
    //         name: $entity->getName(),
    //         pathFileDatabase: $entity->getPathFileDatabase(),
    //         pathProject: $entity->getPathProject(),
    //         description: $entity->getDescription(),
    //         icon: $entity->getIcon(),
    //         color: $entity->getColor(),
    //         isFavory: $entity->isFavory(),
    //         position: $entity->getPosition(),
    //         startDate: $entity->getStartDate(),
    //         endDate: $entity->getEndDate(),
    //         createdByUser: $entity->getCreatedByUser(),
    //         updatedByUser: $entity->getUpdatedByUser(),
    //         createdAt: $entity->getCreatedAt(),
    //         updatedAt: $entity->getUpdatedAt()
    //     );
    // }
}
