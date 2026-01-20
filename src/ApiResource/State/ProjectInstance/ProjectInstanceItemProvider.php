<?php

namespace App\ApiResource\State\ProjectInstance;

use App\Entity\ProjectInstance;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\ProjectInstance\ProjectInstanceMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ProjectInstanceItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private ProjectInstanceMapper $projectInstanceMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof ProjectInstance) {
            return $entity;
        }

        return $this->projectInstanceMapper->entityToItemDto($entity);
    }
}