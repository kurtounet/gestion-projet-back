<?php

declare(strict_types=1);

namespace App\State\SprintTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\SprintTemplate;
use App\Dto\SprintTemplate\SprintTemplateResponseDto;


final class SprintTemplateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

     /**
     * @return SprintTemplate|iterable<SprintTemplate>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof SprintTemplate) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof SprintTemplate) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(SprintTemplate $entity) //: SprintTemplateResponseDto
    {

        return new SprintTemplateResponseDto(

            
$entity->getId(),
$entity->getName(),
$entity->getDescription(),
$entity->getDuration(),
$entity->getCreatedAt(),
$entity->getUpdatedAt(),
            

        );

    }
}
