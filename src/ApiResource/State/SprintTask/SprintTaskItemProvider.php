<?php

namespace App\ApiResource\State\SprintTask;

use App\Entity\SprintTask;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\SprintTask\SprintTaskMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class SprintTaskItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private SprintTaskMapper $sprintTaskMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof SprintTask) {
            return $entity;
        }

        return $this->sprintTaskMapper->entityToItemDto($entity);
    }
}