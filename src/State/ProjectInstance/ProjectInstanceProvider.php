<?php

declare(strict_types=1);

namespace App\State\ProjectInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\ProjectInstance;
use App\Dto\ProjectInstance\ProjectInstanceResponseDto;


final class ProjectInstanceProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

    /**
     * @return ProjectInstance|iterable<ProjectInstance>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof ProjectInstance) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof ProjectInstance) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(ProjectInstance $entity): ProjectInstanceResponseDto
    {

        return new ProjectInstanceResponseDto(


            $entity->getId(),
            $entity->getName(),
            $entity->getDescription(),
            $entity->getStartDate(),
            $entity->getEndDate(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),

            $entity->getStatus()->getId(),
            $entity->getPriority()->getId(),
            $entity->getProjectTemplate()->getId(),
            $entity->getComment()->getId(),

        );
    }
}
