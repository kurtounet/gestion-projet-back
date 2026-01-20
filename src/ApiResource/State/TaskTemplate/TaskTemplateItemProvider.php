<?php

namespace App\ApiResource\State\TaskTemplate;

use App\Entity\TaskTemplate;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Mapper\TaskTemplate\TaskTemplateMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class TaskTemplateItemProvider implements ProviderInterface
{
     public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $itemProvider,
        private TaskTemplateMapper $taskTemplateMapper
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity instanceof TaskTemplate) {
            return $entity;
        }

        return $this->taskTemplateMapper->entityToItemDto($entity);
    }
}