<?php

declare(strict_types=1);

namespace App\State\SprintInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\SprintInstance;
use App\Dto\SprintInstance\SprintInstanceResponseDto;


final class SprintInstanceProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

    /**
     * @return SprintInstance|iterable<SprintInstance>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof SprintInstance) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof SprintInstance) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(SprintInstance $entity) //: SprintInstanceResponseDto
    {

        return new SprintInstanceResponseDto(


            $entity->getId(),
            $entity->getName(),
            $entity->getStartDate(),
            $entity->getEndDate(),
            $entity->getOrder(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),

            // $entity->getProjectInstance()->getId(),
            // $entity->getPriority()->getId(),
            // $entity->getSprintTemplate()->getId(),
            // $entity->getStatus()->getId(),
            // $entity->getComment()->getId(),
            // $entity->getSprintDependency()->getId(),

        );
    }
}
