<?php

namespace App\ApiResource\State\SprintInstance;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\SprintInstance\SprintInstanceMapper;
use App\Entity\SprintInstance;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintInstanceItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private SprintInstanceMapper $sprintInstanceMapper,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof SprintInstance) {
            return $entity;
        }

        return $this->sprintInstanceMapper->entityToItemDto($entity);
    }
}
