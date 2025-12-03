<?php

declare(strict_types=1);

namespace App\State\SprintTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\SprintTask;
use App\Dto\SprintTask\SprintTaskResponseDto;


final class SprintTaskProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

     /**
     * @return SprintTask|iterable<SprintTask>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof SprintTask) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof SprintTask) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(SprintTask $entity) //: SprintTaskResponseDto
    {

        return new SprintTaskResponseDto(

            
$entity->getId(),
$entity->getTaskOrder(),
$entity->getCreatedAt(),
$entity->getUpdatedAt(),
            
$entity->getSprintTemplate()->getId(),
$entity->getTaskTemplate()->getId(),

        );

    }
}
