<?php

declare(strict_types=1);

namespace App\State\ProjectTemplate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\ProjectTemplate;
use App\Dto\ProjectTemplate\ProjectTemplateResponseDto;


final class ProjectTemplateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private readonly ProviderInterface $collectionProvider,

        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private readonly ProviderInterface $itemProvider,
    ) {}

     /**
     * @return ProjectTemplate|iterable<ProjectTemplate>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        // Collection : on délègue au provider Doctrine
        if ($operation instanceof CollectionOperationInterface) {

            $result = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtos = [];
            foreach ($result as $entity) {
                if (!$entity instanceof ProjectTemplate) {
                    continue;
                }
                $dtos[] = $this->mapEntityToDto($entity);
            }
            return $dtos;
        }

        // Item : idem, on délègue au provider Doctrine

        $item = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($item instanceof ProjectTemplate) {
            return $this->mapEntityToDto($item);
        }

        return $item;
    }

    private function mapEntityToDto(ProjectTemplate $entity) //: ProjectTemplateResponseDto
    {

        return new ProjectTemplateResponseDto(

            
$entity->getId(),
$entity->getName(),
$entity->getDescription(),
$entity->getDuration(),
$entity->getCreatedAt(),
$entity->getUpdatedAt(),
            

        );

    }
}
