<?php

declare(strict_types=1);

namespace App\State\TaskInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\TaskInstance;
use App\Dto\TaskInstance\TaskInstanceResponseDto;


final class TaskInstanceProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

     /**
     * @return TaskInstance|iterable<TaskInstance>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof TaskInstance) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof TaskInstance) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(TaskInstance $entity) //: TaskInstanceResponseDto
    {

        return new TaskInstanceResponseDto(

            
$entity->getId(),
$entity->getName(),
$entity->getDescription(),
$entity->getStartDate(),
$entity->getDueDate(),
$entity->getOrder(),
$entity->getCreatedAt(),
$entity->getUpdatedAt(),
            
$entity->getUser()->getId(),
$entity->getTaskTemplate()->getId(),
$entity->getSprintInstance()->getId(),
$entity->getPriority()->getId(),
$entity->getStatus()->getId(),
$entity->getTypeTask()->getId(),
$entity->getParentTask()->getId(),
$entity->getDependency()->getId(),
$entity->getComment()->getId(),

        );

    }
}
